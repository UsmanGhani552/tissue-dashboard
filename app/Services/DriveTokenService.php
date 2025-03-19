<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DriveTokenService {
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

    public static function getDriveData($folderId){
        $query = "'$folderId' in parents"; // Remove MIME type filter
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . DriveTokenService::token(),
        ])->get('https://www.googleapis.com/drive/v3/files', [
            'q' => $query,
            'fields' => 'files(id, name, mimeType, createdTime, modifiedTime)',
        ]);
        if ($response->successful()) {
            $files = $response->json()['files'];
            $parsedFiles = [];

            foreach ($files as $file) {
                $parsedFiles[] = self::processFile($file);
            }
            return $parsedFiles;
        } else {
            return response('Failed to retrieve files from the folder', $response->status());
        }
    } 

    private static function processFile($file)
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
                'content' => 'Non-Excel and Non-Google Sheets file content not parsed',
            ];
        }
    }

    private static function processExcelFile($file)
    {
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
                'content' => $parsedData, // Parsed Excel content
            ];
        } else {
            return [
                'id' => $file['id'],
                'name' => $file['name'],
                'mimeType' => $file['mimeType'],
                'createdTime' => $file['createdTime'],
                'modifiedTime' => $file['modifiedTime'],
                'content' => 'Failed to fetch content',
            ];
        }
    }

    private static function processGoogleSheetFile($file)
    {
        $sheetContentResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . DriveTokenService::token(),
        ])->get("https://sheets.googleapis.com/v4/spreadsheets/{$file['id']}/values/Sheet1");
        // dd($sheetContentResponse);
        if ($sheetContentResponse->successful()) {
            $parsedData = $sheetContentResponse->json()['values'];

            return [
                'id' => $file['id'],
                'name' => $file['name'],
                'mimeType' => $file['mimeType'],
                'createdTime' => $file['createdTime'],
                'modifiedTime' => $file['modifiedTime'],
                'content' => $parsedData, // Parsed Google Sheets content
            ];
        } else {
            return [
                'id' => $file['id'],
                'name' => $file['name'],
                'mimeType' => $file['mimeType'],
                'createdTime' => $file['createdTime'],
                'modifiedTime' => $file['modifiedTime'],
                'content' => 'Failed to fetch content',
            ];
        }
    }
}