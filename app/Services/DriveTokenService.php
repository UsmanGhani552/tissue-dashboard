<?php

namespace App\Services;

use App\Jobs\ProcessDriveFileJob;
use App\Models\Folder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\Constraint\Count;
use Termwind\Components\Dd;

class DriveTokenService
{
    private static function token()
    {
        $client_id = \Config('services.google.client_id');
        $client_secret = \Config('services.google.client_secret');
        $refresh_token = \Config('services.google.refresh_token');
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',
        ]);
        $accessToken = json_decode((string)$response->getBody(), true)['access_token'];
        return $accessToken;
    }

    // public static function getDriveData($folderId){
    //     $query = "'$folderId' in parents and mimeType='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'";

    //     // Apply modified time filter if provided
    //     // if ($modifiedTime) {
    //     //     $query .= " and modifiedTime > '$modifiedTime'";
    //     // }
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . DriveTokenService::token(),
    //     ])->get('https://www.googleapis.com/drive/v3/files', [
    //         'q' => $query,
    //         'fields' => 'files(id, name, mimeType, createdTime)',
    //     ]);
    //     if ($response->successful()) {
    //         $files = $response->json()['files'];
    //         $parsedFiles = [];

    //         foreach ($files as $file) {
    //             if ($file['mimeType'] === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
    //                 $fileContentResponse = Http::withHeaders([
    //                     'Authorization' => 'Bearer ' . DriveTokenService::token(),
    //                 ])->get("https://www.googleapis.com/drive/v3/files/{$file['id']}", [
    //                     'alt' => 'media',
    //                 ]);

    //                 if ($fileContentResponse->successful()) {
    //                     // Step 2: Save file temporarily
    //                     $tempFilePath = storage_path("app/temp/{$file['name']}");
    //                     Storage::put("temp/{$file['name']}", $fileContentResponse->body());

    //                     // Step 3: Parse the Excel file
    //                     $parsedData = Excel::toArray([], $tempFilePath);

    //                     $parsedFiles[] = [
    //                         'id' => $file['id'],
    //                         'name' => $file['name'],
    //                         'mimeType' => $file['mimeType'],
    //                         'createdTime' => $file['createdTime'],
    //                         'content' => $parsedData, // Parsed Excel content
    //                     ];

    //                     // Step 4: Remove the temporary file
    //                     Storage::delete("temp/{$file['name']}");
    //                 } else {
    //                     $parsedFiles[] = [
    //                         'id' => $file['id'],
    //                         'name' => $file['name'],
    //                         'mimeType' => $file['mimeType'],
    //                         'createdTime' => $file['createdTime'],
    //                         'content' => 'Failed to fetch content',
    //                     ];
    //                 }
    //             }
    //         }
    //         return $parsedFiles;
    //     } else {
    //         return response('Failed to retrieve files from the folder', $response->status());
    //     }
    // }

    public static function getDriveData($folderId, $time)
    {
        try {
            $folder = Folder::where('drive_folder_id', $folderId)->first();
            $modifiedTime = $folder->updated_at;
            $query = "'$folderId' in parents and (mimeType='application/vnd.google-apps.spreadsheet' or mimeType='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')" . ($modifiedTime ? " and modifiedTime > '$modifiedTime'" : '');
            // $query = "'$folderId' in parents and modifiedTime > '2025-04-08T11:27:00'";
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . DriveTokenService::token(),
            ])->get('https://www.googleapis.com/drive/v3/files', [
                'q' => $query,
                'fields' => 'files(id, name, mimeType, createdTime, modifiedTime)',
            ]);
            Log::info($response->json());
            $folder->updated_at = $time;
            $folder->save();
            if ($response->successful()) {
                $files = $response->json()['files'];
                $parsedFiles = [];
                foreach ($files as $file) {
                    try {
                        ProcessDriveFileJob::dispatch($file, $folder->id);
                    } catch (\Throwable $th) {
                        logger()->error("Import job failed: " . $th->getMessage());
                    }
                }
                return $parsedFiles;
            } else {
                return response('Failed to retrieve files from the folder', $response->status());
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }

    public static function processFile($file)
    {
        if ($file['mimeType'] === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            return self::processExcelFile($file);
        } elseif ($file['mimeType'] === 'application/vnd.google-apps.spreadsheet') {
            return self::processGoogleSheetFile($file);
        } else {
            return [
                'id' => $file['id'],
                'name' => $file['name'],
                'mimeType' => $file['mimeType'],
                'createdTime' => $file['createdTime'],
                'modifiedTime' => $file['modifiedTime'],
                'content' => [],
                'message' => 'Unsupported file type'
            ];
        }
    }

    public static function processExcelFileErrorFiles($fileID, $filename)
    {
        $fileContentResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . DriveTokenService::token(),
        ])->get("https://www.googleapis.com/drive/v3/files/{$fileID}", [
            'alt' => 'media',
        ]);
        if ($fileContentResponse->successful()) {
            // Step 2: Save file temporarily
            $tempFilePath = storage_path("app/temp/{$filename}");
            Storage::put("temp/{$filename}", $fileContentResponse->body());

            // Step 3: Parse the Excel file
            $parsedData = Excel::toArray([], $tempFilePath);

            // Step 4: Remove the temporary file
            Storage::delete("temp/{$filename}");

            return [
                'id' => $fileID,
                'name' => $filename,
                // 'mimeType' => $fileContentResponse['mimeType'],
                // 'createdTime' => $file['createdTime'],
                // 'modifiedTime' => $file['modifiedTime'],
                'content' => DriveTokenService::formatResponse($parsedData), // Parsed Excel content
            ];
        } else {
            log::error("Failed to fetch content for sheet: {$fileContentResponse->body()}");
            return [
                'id' => $fileID,
                // 'name' => $file['name'],
                // 'mimeType' => $file['mimeType'],
                // 'createdTime' => $file['createdTime'],
                // 'modifiedTime' => $file['modifiedTime'],
                'content' => 'Failed to fetch content',
            ];
        }
    }
    private static function processExcelFile($file)
    {
        try {
            //code...
            $fileContentResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . DriveTokenService::token(),
            ])->get("https://www.googleapis.com/drive/v3/files/{$file['id']}", [
                'alt' => 'media',
            ]);

            if ($fileContentResponse->successful()) {
                // Step 2: Save file temporarily
                $tempFilePath = storage_path("app/temp/{$file['name']}");
                Storage::put("temp/{$file['name']}", $fileContentResponse->body());

                // Step 3: Parse the Excel file
                $parsedData = Excel::toArray([], $tempFilePath);

                // Step 4: Remove the temporary file
                Storage::delete("temp/{$file['name']}");

                return [
                    'id' => $file['id'],
                    'name' => $file['name'],
                    'mimeType' => $file['mimeType'],
                    'createdTime' => $file['createdTime'],
                    'modifiedTime' => $file['modifiedTime'],
                    'content' => DriveTokenService::formatResponse($parsedData), // Parsed Excel content
                ];
            } else {
                log::error("Failed to fetch content for sheet: {$fileContentResponse->body()}");
                return [
                    'id' => $file['id'],
                    'name' => $file['name'],
                    'mimeType' => $file['mimeType'],
                    'createdTime' => $file['createdTime'],
                    'modifiedTime' => $file['modifiedTime'],
                    'content' => 'Failed to fetch content',
                ];
            }
        } catch (\Throwable $th) {
            log::error("Failed to fetch content for sheet: {$fileContentResponse->body()}");
            return [
                'id' => $file['id'],
                'name' => $file['name'],
                'mimeType' => $file['mimeType'],
                'createdTime' => $file['createdTime'],
                'modifiedTime' => $file['modifiedTime'],
                'content' => $th->getMessage(),
            ];
        }
    }

    public static function processGoogleErrorSheetFile($fileId, $filename)
    {
        $sheetMetadataResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . DriveTokenService::token(),
        ])->get("https://sheets.googleapis.com/v4/spreadsheets/{$fileId}", [
            'fields' => 'properties,sheets,spreadsheetId,mimeType,modifiedTime' // Add the fields you need
        ]);
        if ($sheetMetadataResponse->successful()) {
            $sheets = $sheetMetadataResponse->json()['sheets'];
            $allSheetData = []; // To store data from all sheets
            foreach ($sheets as $sheet) {
                $sheetName = $sheet['properties']['title']; // Get the sheet name

                $sheetContentResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . DriveTokenService::token(),
                ])->timeout(600)->get("https://sheets.googleapis.com/v4/spreadsheets/{$fileId}/values/{$sheetName}");
                if ($sheetContentResponse->successful()) {
                    $sheetJson = $sheetContentResponse->json();
                    if (!isset($sheetJson['values'])) {
                        $sheetJson['values'] = []; // Initialize if not set
                    }
                    $parsedData = $sheetJson['values'];
                    $allSheetData[] = $parsedData; // Store data by sheet name
                } else {
                    log::error("Failed to fetch content for sheet: {$sheetContentResponse->body()}");
                    $allSheetData[] = 'Failed to fetch content'; // Handle failure for specific sheet
                }
            }
            return [
                'id' => $fileId,
                'name' => $filename,
                // 'mimeType' => $file['mimeType'],
                // 'createdTime' => $file['createdTime'],
                // 'modifiedTime' => $file['modifiedTime'],
                'content' => DriveTokenService::formatResponse($allSheetData), // Data from all sheets
            ];
        }
        log::error("Failed to fetch metadata for sheet: {$sheetMetadataResponse->body()}");
        return [
            'id' => $fileId,
            'name' => $filename,
            // 'mimeType' => $file['mimeType'],
            // 'createdTime' => $file['createdTime'],
            // 'modifiedTime' => $file['modifiedTime'],
            'content' => 'Failed to fetch content',
        ];
    }
    private static function processGoogleSheetFile($file)
    {
        try {
            //code...
            $sheetMetadataResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . DriveTokenService::token(),
            ])->get("https://sheets.googleapis.com/v4/spreadsheets/{$file['id']}");
    
            if ($sheetMetadataResponse->successful()) {
                $sheets = $sheetMetadataResponse->json()['sheets'];
                $allSheetData = []; // To store data from all sheets
                foreach ($sheets as $sheet) {
                    $sheetName = $sheet['properties']['title']; // Get the sheet name
    
                    $sheetContentResponse = Http::withHeaders([
                        'Authorization' => 'Bearer ' . DriveTokenService::token(),
                    ])->timeout(600)->get("https://sheets.googleapis.com/v4/spreadsheets/{$file['id']}/values/{$sheetName}");
                    if ($sheetContentResponse->successful()) {
                        $sheetJson = $sheetContentResponse->json();
                        if (!isset($sheetJson['values'])) {
                            $sheetJson['values'] = []; // Initialize if not set
                        }
                        $parsedData = $sheetJson['values'];
                        $allSheetData[] = $parsedData; // Store data by sheet name
                    } else {
                        $allSheetData[] = 'Failed to fetch content'; // Handle failure for specific sheet
                    }
                }
    
                return [
                    'id' => $file['id'],
                    'name' => $file['name'],
                    'mimeType' => $file['mimeType'],
                    'createdTime' => $file['createdTime'],
                    'modifiedTime' => $file['modifiedTime'],
                    'content' => DriveTokenService::formatResponse($allSheetData), // Data from all sheets
                ];
            }
            log::error("Failed to fetch metadata for sheet: {$sheetMetadataResponse->body()}");
            return [
                'id' => $file['id'],
                'name' => $file['name'],
                'mimeType' => $file['mimeType'],
                'createdTime' => $file['createdTime'],
                'modifiedTime' => $file['modifiedTime'],
                'content' => 'Failed to fetch content',
            ];
        } catch (\Throwable $th) {
            log::error("Failed to fetch metadata for sheet: {$sheetMetadataResponse->body()}");
            return [
                'id' => $file['id'],
                'name' => $file['name'],
                'mimeType' => $file['mimeType'],
                'createdTime' => $file['createdTime'],
                'modifiedTime' => $file['modifiedTime'],
                'content' => $th->getMessage(),
            ];
        }
    }
    private static function formatResponse_v1($content)
    {
        if (
            is_array($content) &&
            count($content) > 0 &&
            is_array($content[0]) &&
            count($content[0]) > 0 &&
            !is_array($content[0][0])
        ) {
            $content = [$content];
        }
        return $content;
    }

    private static function formatResponse($content)
    {
        try {
            if (!is_array($content[0][0])) {
                $content = [$content];
            }
        } catch (\Exception $e) {
        }
        return $content;
    }
}
