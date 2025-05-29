<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tissue</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/short-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    </head>

<body>
    <!-- off canvas html start -->
    <div class="parent">
        <div class="container-fluid">
            <div class="row">
                {{-- <div class="col-lg-6">
                    <div class="sidebar" data-bs-scroll="true" tabindex="-1" id="Id1"
                        aria-labelledby="Enable both scrolling & backdrop">
                        <div class="sidebar-body">
                            <div class="logoDiv">
                                <div class="logo">
                                    <img src="assets/images/logo.png" alt="hello">
                                </div>
                                <button class="btn btn-primary triggerBtn" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path
                                            d="M432 48H208c-17.7 0-32 14.3-32 32V96H128V80c0-44.2 35.8-80 80-80H432c44.2 0 80 35.8 80 80V304c0 44.2-35.8 80-80 80H416V336h16c17.7 0 32-14.3 32-32V80c0-17.7-14.3-32-32-32zM48 448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V256H48V448zM64 128H320c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V192c0-35.3 28.7-64 64-64z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="offcanvasnav">
                                <div class="nav-buttons">
                                    <!-- <a class="btn btn-primary" href="#" role="button">Button</a> -->
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="currentweek-tab" data-bs-toggle="tab"
                                                data-bs-target="#currentweek" type="button" role="tab"
                                                aria-controls="home" aria-selected="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <g clip-path="url(#clip0_31_38)">
                                                        <path
                                                            d="M4.66667 0H2.66667C1.19391 0 0 1.19391 0 2.66667V4.66667C0 6.13943 1.19391 7.33333 2.66667 7.33333H4.66667C6.13943 7.33333 7.33333 6.13943 7.33333 4.66667V2.66667C7.33333 1.19391 6.13943 0 4.66667 0Z"
                                                            fill="#42526E" fill-opacity="0.5" />
                                                        <path
                                                            d="M13.3334 0H11.3334C9.86066 0 8.66675 1.19391 8.66675 2.66667V4.66667C8.66675 6.13943 9.86066 7.33333 11.3334 7.33333H13.3334C14.8062 7.33333 16.0001 6.13943 16.0001 4.66667V2.66667C16.0001 1.19391 14.8062 0 13.3334 0Z"
                                                            fill="#42526E" fill-opacity="0.5" />
                                                        <path
                                                            d="M4.66667 8.6665H2.66667C1.19391 8.6665 0 9.86041 0 11.3332V13.3332C0 14.8059 1.19391 15.9998 2.66667 15.9998H4.66667C6.13943 15.9998 7.33333 14.8059 7.33333 13.3332V11.3332C7.33333 9.86041 6.13943 8.6665 4.66667 8.6665Z"
                                                            fill="#42526E" fill-opacity="0.5" />
                                                        <path
                                                            d="M13.3334 8.6665H11.3334C9.86066 8.6665 8.66675 9.86041 8.66675 11.3332V13.3332C8.66675 14.8059 9.86066 15.9998 11.3334 15.9998H13.3334C14.8062 15.9998 16.0001 14.8059 16.0001 13.3332V11.3332C16.0001 9.86041 14.8062 8.6665 13.3334 8.6665Z"
                                                            fill="#42526E" fill-opacity="0.5" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_31_38">
                                                            <rect width="16" height="16" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                Current Week
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="weekly-tab" data-bs-toggle="tab"
                                                data-bs-target="#weekly" type="button" role="tab"
                                                aria-controls="profile" aria-selected="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <g clip-path="url(#clip0_31_45)">
                                                        <path
                                                            d="M0 12.6665C0.00105857 13.5502 0.352588 14.3975 0.97748 15.0224C1.60237 15.6473 2.4496 15.9988 3.33333 15.9998H12.6667C13.5504 15.9988 14.3976 15.6473 15.0225 15.0224C15.6474 14.3975 15.9989 13.5502 16 12.6665V6.6665H0V12.6665ZM11.3333 9.6665C11.5311 9.6665 11.7245 9.72515 11.8889 9.83503C12.0534 9.94492 12.1815 10.1011 12.2572 10.2838C12.3329 10.4665 12.3527 10.6676 12.3141 10.8616C12.2755 11.0556 12.1803 11.2338 12.0404 11.3736C11.9006 11.5135 11.7224 11.6087 11.5284 11.6473C11.3344 11.6859 11.1334 11.6661 10.9507 11.5904C10.7679 11.5147 10.6117 11.3865 10.5019 11.2221C10.392 11.0576 10.3333 10.8643 10.3333 10.6665C10.3333 10.4013 10.4387 10.1469 10.6262 9.9594C10.8138 9.77186 11.0681 9.6665 11.3333 9.6665ZM8 9.6665C8.19778 9.6665 8.39112 9.72515 8.55557 9.83503C8.72002 9.94492 8.84819 10.1011 8.92388 10.2838C8.99957 10.4665 9.01937 10.6676 8.98079 10.8616C8.9422 11.0556 8.84696 11.2338 8.70711 11.3736C8.56726 11.5135 8.38907 11.6087 8.19509 11.6473C8.00111 11.6859 7.80004 11.6661 7.61732 11.5904C7.43459 11.5147 7.27841 11.3865 7.16853 11.2221C7.05865 11.0576 7 10.8643 7 10.6665C7 10.4013 7.10536 10.1469 7.29289 9.9594C7.48043 9.77186 7.73478 9.6665 8 9.6665ZM4.66667 9.6665C4.86445 9.6665 5.05779 9.72515 5.22224 9.83503C5.38669 9.94492 5.51486 10.1011 5.59055 10.2838C5.66623 10.4665 5.68604 10.6676 5.64745 10.8616C5.60887 11.0556 5.51363 11.2338 5.37377 11.3736C5.23392 11.5135 5.05574 11.6087 4.86176 11.6473C4.66778 11.6859 4.46671 11.6661 4.28398 11.5904C4.10126 11.5147 3.94508 11.3865 3.8352 11.2221C3.72532 11.0576 3.66667 10.8643 3.66667 10.6665C3.66667 10.4013 3.77202 10.1469 3.95956 9.9594C4.1471 9.77186 4.40145 9.6665 4.66667 9.6665Z"
                                                            fill="#42526E" fill-opacity="0.5" />
                                                        <path
                                                            d="M12.6667 1.33333H12V0.666667C12 0.489856 11.9298 0.320286 11.8047 0.195262C11.6797 0.0702379 11.5101 0 11.3333 0C11.1565 0 10.987 0.0702379 10.8619 0.195262C10.7369 0.320286 10.6667 0.489856 10.6667 0.666667V1.33333H5.33333V0.666667C5.33333 0.489856 5.2631 0.320286 5.13807 0.195262C5.01305 0.0702379 4.84348 0 4.66667 0C4.48986 0 4.32029 0.0702379 4.19526 0.195262C4.07024 0.320286 4 0.489856 4 0.666667V1.33333H3.33333C2.4496 1.33439 1.60237 1.68592 0.97748 2.31081C0.352588 2.93571 0.00105857 3.78294 0 4.66667L0 5.33333H16V4.66667C15.9989 3.78294 15.6474 2.93571 15.0225 2.31081C14.3976 1.68592 13.5504 1.33439 12.6667 1.33333Z"
                                                            fill="#42526E" fill-opacity="0.5" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_31_45">
                                                            <rect width="16" height="16" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                Weekly
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="monthly-tab" data-bs-toggle="tab"
                                                data-bs-target="#monthly" type="button" role="tab">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <g clip-path="url(#clip0_31_50)">
                                                        <path
                                                            d="M12.6667 2.01467C12.6667 2.00933 12.6667 2.00533 12.6667 2V0.666667C12.6667 0.489856 12.5964 0.320286 12.4714 0.195262C12.3464 0.0702379 12.1768 0 12 0C11.8232 0 11.6536 0.0702379 11.5286 0.195262C11.4036 0.320286 11.3333 0.489856 11.3333 0.666667V1.4C11.1139 1.35544 10.8906 1.33311 10.6667 1.33333H10V0.666667C10 0.489856 9.92976 0.320286 9.80474 0.195262C9.67971 0.0702379 9.51014 0 9.33333 0C9.15652 0 8.98695 0.0702379 8.86193 0.195262C8.73691 0.320286 8.66667 0.489856 8.66667 0.666667V1.33333H7.33333V0.666667C7.33333 0.489856 7.2631 0.320286 7.13807 0.195262C7.01305 0.0702379 6.84348 0 6.66667 0C6.48986 0 6.32029 0.0702379 6.19526 0.195262C6.07024 0.320286 6 0.489856 6 0.666667V1.33333H5.33333C5.10944 1.33311 4.88609 1.35544 4.66667 1.4V0.666667C4.66667 0.489856 4.59643 0.320286 4.4714 0.195262C4.34638 0.0702379 4.17681 0 4 0C3.82319 0 3.65362 0.0702379 3.5286 0.195262C3.40357 0.320286 3.33333 0.489856 3.33333 0.666667V2V2.01467C2.92052 2.32292 2.58513 2.72303 2.35371 3.18332C2.12229 3.64362 2.00119 4.15147 2 4.66667V12.6667C2.00106 13.5504 2.35259 14.3976 2.97748 15.0225C3.60237 15.6474 4.4496 15.9989 5.33333 16H10.6667C11.5504 15.9989 12.3976 15.6474 13.0225 15.0225C13.6474 14.3976 13.9989 13.5504 14 12.6667V4.66667C13.9988 4.15147 13.8777 3.64362 13.6463 3.18332C13.4149 2.72303 13.0795 2.32292 12.6667 2.01467ZM8 11.3333H5.33333C5.15652 11.3333 4.98695 11.2631 4.86193 11.1381C4.7369 11.013 4.66667 10.8435 4.66667 10.6667C4.66667 10.4899 4.7369 10.3203 4.86193 10.1953C4.98695 10.0702 5.15652 10 5.33333 10H8C8.17681 10 8.34638 10.0702 8.4714 10.1953C8.59643 10.3203 8.66667 10.4899 8.66667 10.6667C8.66667 10.8435 8.59643 11.013 8.4714 11.1381C8.34638 11.2631 8.17681 11.3333 8 11.3333ZM10.6667 8.66667H5.33333C5.15652 8.66667 4.98695 8.59643 4.86193 8.47141C4.7369 8.34638 4.66667 8.17681 4.66667 8C4.66667 7.82319 4.7369 7.65362 4.86193 7.5286C4.98695 7.40357 5.15652 7.33333 5.33333 7.33333H10.6667C10.8435 7.33333 11.013 7.40357 11.1381 7.5286C11.2631 7.65362 11.3333 7.82319 11.3333 8C11.3333 8.17681 11.2631 8.34638 11.1381 8.47141C11.013 8.59643 10.8435 8.66667 10.6667 8.66667ZM10.6667 6H5.33333C5.15652 6 4.98695 5.92976 4.86193 5.80474C4.7369 5.67971 4.66667 5.51014 4.66667 5.33333C4.66667 5.15652 4.7369 4.98695 4.86193 4.86193C4.98695 4.7369 5.15652 4.66667 5.33333 4.66667H10.6667C10.8435 4.66667 11.013 4.7369 11.1381 4.86193C11.2631 4.98695 11.3333 5.15652 11.3333 5.33333C11.3333 5.51014 11.2631 5.67971 11.1381 5.80474C11.013 5.92976 10.8435 6 10.6667 6Z"
                                                            fill="#A0A8B7" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_31_50">
                                                            <rect width="16" height="16" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                Monthly
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab"
                                                data-bs-target="#settings" type="button" role="tab">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <g clip-path="url(#clip0_31_58)">
                                                        <path
                                                            d="M10.6667 8.6665C10.3563 9.08049 9.95364 9.4165 9.49079 9.64793C9.02794 9.87935 8.51757 9.99984 8.00008 9.99984C7.4826 9.99984 6.97222 9.87935 6.50937 9.64793C6.04652 9.4165 5.64391 9.08049 5.33342 8.6665C5.0721 9.01875 4.74327 9.31544 4.3661 9.53928C3.98893 9.76312 3.57097 9.90962 3.13659 9.97025C2.70221 10.0309 2.26011 10.0044 1.83607 9.8924C1.41202 9.78039 1.01452 9.58507 0.666748 9.31784V12.6665C0.667807 13.5502 1.01934 14.3975 1.64423 15.0224C2.26912 15.6473 3.11635 15.9988 4.00008 15.9998H12.0001C12.8838 15.9988 13.731 15.6473 14.3559 15.0224C14.9808 14.3975 15.3324 13.5502 15.3334 12.6665V9.31584C14.9858 9.58317 14.5884 9.77863 14.1644 9.89079C13.7404 10.003 13.2984 10.0296 12.864 9.96916C12.4296 9.90872 12.0116 9.76241 11.6344 9.53876C11.2572 9.31511 10.9282 9.0186 10.6667 8.6665Z"
                                                            fill="#42526E" fill-opacity="0.5" />
                                                        <path
                                                            d="M14.4667 2.08738C14.3377 1.49344 14.0084 0.961912 13.5341 0.581886C13.0598 0.201859 12.4692 -0.00356479 11.8614 4.68218e-05H11.3334V2.00005C11.3334 2.17686 11.2632 2.34643 11.1382 2.47145C11.0131 2.59648 10.8436 2.66671 10.6667 2.66671C10.4899 2.66671 10.3204 2.59648 10.1953 2.47145C10.0703 2.34643 10.0001 2.17686 10.0001 2.00005V4.68218e-05H6.00008V2.00005C6.00008 2.17686 5.92984 2.34643 5.80482 2.47145C5.67979 2.59648 5.51023 2.66671 5.33342 2.66671C5.1566 2.66671 4.98703 2.59648 4.86201 2.47145C4.73699 2.34643 4.66675 2.17686 4.66675 2.00005V4.68218e-05H4.13875C3.53087 -0.00353217 2.94025 0.201987 2.4659 0.582145C1.99155 0.962303 1.66232 1.49399 1.53341 2.08805L0.681415 5.93338L0.666748 6.68005C0.667624 6.94269 0.720222 7.20259 0.82154 7.44491C0.922858 7.68722 1.07091 7.90721 1.25725 8.09231C1.63357 8.46613 2.14298 8.67515 2.67341 8.67338C2.93606 8.67251 3.19596 8.61991 3.43827 8.51859C3.68059 8.41727 3.90058 8.26922 4.08568 8.08288C4.27077 7.89654 4.41736 7.67557 4.51706 7.43259C4.61676 7.1896 4.66762 6.92936 4.66675 6.66671C4.66675 6.4899 4.73699 6.32033 4.86201 6.19531C4.98703 6.07029 5.1566 6.00005 5.33342 6.00005C5.51023 6.00005 5.67979 6.07029 5.80482 6.19531C5.92984 6.32033 6.00008 6.4899 6.00008 6.66671C6.00008 7.19715 6.21079 7.70585 6.58587 8.08093C6.96094 8.456 7.46965 8.66671 8.00008 8.66671C8.53051 8.66671 9.03922 8.456 9.4143 8.08093C9.78937 7.70585 10.0001 7.19715 10.0001 6.66671C10.0001 6.4899 10.0703 6.32033 10.1953 6.19531C10.3204 6.07029 10.4899 6.00005 10.6667 6.00005C10.8436 6.00005 11.0131 6.07029 11.1382 6.19531C11.2632 6.32033 11.3334 6.4899 11.3334 6.66671C11.3334 7.19715 11.5441 7.70585 11.9192 8.08093C12.2943 8.456 12.803 8.66671 13.3334 8.66671C13.8638 8.66671 14.3726 8.456 14.7476 8.08093C15.1227 7.70585 15.3334 7.19715 15.3334 6.66671V6.07138L14.4667 2.08738Z"
                                                            fill="#42526E" fill-opacity="0.5" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_31_58">
                                                            <rect width="16" height="16" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                Settings
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="link-tab" data-bs-toggle="tab"
                                                data-bs-target="#link" type="button" role="tab">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <g clip-path="url(#clip0_41_60)">
                                                        <path
                                                            d="M0.961029 15.039C2.2424 16.3205 4.32004 16.3205 5.60141 15.039L9.21725 11.4232C7.94003 11.5714 7.16989 11.1409 6.91245 11.0764L4.2756 13.7132C3.72726 14.2615 2.83517 14.2615 2.28683 13.7132C1.73849 13.165 1.73849 12.2728 2.28683 11.7246C2.38803 11.6232 6.5527 7.45857 6.42111 7.59029C6.95602 7.05526 7.86105 7.04158 8.40976 7.59029C8.45419 7.63472 8.48764 7.68514 8.52475 7.7336C8.7225 7.71468 8.91122 7.75179 9.07272 7.59029L10.0276 6.63546C9.93503 6.50911 9.84995 6.37887 9.73557 6.26449C8.46457 4.99337 6.34116 5.01852 5.09518 6.26449L0.961029 10.3986C-0.320343 11.68 -0.320343 13.7576 0.961029 15.039Z"
                                                            fill="#42526E" fill-opacity="0.5" />
                                                        <path
                                                            d="M15.0389 0.961026C13.7576 -0.320342 11.6799 -0.320342 10.3986 0.961026L6.93945 4.42012C8.21667 4.27193 8.98682 4.70247 9.24426 4.76692L11.7245 2.28683C12.2728 1.73849 13.1648 1.73849 13.7131 2.28683C14.2615 2.83517 14.2615 3.72725 13.7131 4.27559L10.4982 7.49055L9.7356 8.253C9.20068 8.78815 8.29565 8.80182 7.74695 8.253C7.70251 8.20869 7.66907 8.15827 7.63196 8.10981C7.4342 8.12873 7.24548 8.0915 7.08398 8.253L6.12915 9.20783C6.22168 9.33417 6.30676 9.46454 6.42114 9.57892C7.69214 10.85 9.81555 10.8248 11.0615 9.57892L15.0389 5.60139C16.3203 4.32002 16.3203 2.24239 15.0389 0.961026Z"
                                                            fill="#42526E" fill-opacity="0.5" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_41_60">
                                                            <rect width="16" height="16" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                Create Link
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="profile-dropdown dropdown-center">
                                <div class="dropup open">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId"
                                        data-bs-toggle="dropdown">
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="assets/images/user.png" alt="">
                                            </div>
                                            <div class="col-8">
                                                <h4>Thomas</h4>
                                                <p>Admin</p>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="triggerId">
                                        <button class="dropdown-item" href="#">LogOut</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> --}}
                @include('layout.sidebar')
                <div class="col-lg-6 tabSec expand">
                    <header>
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button> -->
                                <div class="headerRow d-flex align-items-center">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                        <button class="btn btn-primary triggerBtn2" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path
                                                    d="M432 48H208c-17.7 0-32 14.3-32 32V96H128V80c0-44.2 35.8-80 80-80H432c44.2 0 80 35.8 80 80V304c0 44.2-35.8 80-80 80H416V336h16c17.7 0 32-14.3 32-32V80c0-17.7-14.3-32-32-32zM48 448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V256H48V448zM64 128H320c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V192c0-35.3 28.7-64 64-64z" />
                                            </svg>
                                        </button>
                                        <h2>Dashboard</h2>
                                    </ul>
                                    <a href="{{ route('error-files') }}" class="btn r-button">Error Files</a>
                                    {{-- <form class="d-flex" role="search">
                                        <div class="searchBtn">
                                            <input class="form-control me-2" type="search" placeholder="Search"
                                                aria-label="Search">
                                            <button class="btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M0 416c0 17.7 14.3 32 32 32l54.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 448c17.7 0 32-14.3 32-32s-14.3-32-32-32l-246.7 0c-12.3-28.3-40.5-48-73.3-48s-61 19.7-73.3 48L32 384c-17.7 0-32 14.3-32 32zm128 0a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM320 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32-80c-32.8 0-61 19.7-73.3 48L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l246.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48l54.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-54.7 0c-12.3-28.3-40.5-48-73.3-48zM192 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm73.3-64C253 35.7 224.8 16 192 16s-61 19.7-73.3 48L32 64C14.3 64 0 78.3 0 96s14.3 32 32 32l86.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 128c17.7 0 32-14.3 32-32s-14.3-32-32-32L265.3 64z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </form> --}}
                                </div>
                            </div>
                        </nav>
                    </header>
                    @yield('content')

                </div>
            </div>
        </div>
    </div>
    <!-- Tab panes -->
    <!-- off canvas html start -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        const toggleButton = document.querySelector('.triggerBtn');
        const toggleButton2 = document.querySelector('.triggerBtn2');
        const tabContent = document.querySelector('.tabSec');
        const sideBar = document.querySelector('.sidebar');

        // Add click event listener to toggle button
        toggleButton.addEventListener('click', () => {
            tabContent.classList.toggle('expand');
            sideBar.classList.toggle('expand');
        });
        toggleButton2.addEventListener('click', () => {
            tabContent.classList.toggle('expand');
            sideBar.classList.toggle('expand');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#mainTable').DataTable({
                scrollX: true, // Enable horizontal scrolling
                scrollY: '220px',
                scrollCollapse: true,
                ordering: false,
                paging: false, // Enable horizontal scrolling
                // "paging": true, // Enable pagination
                // "pageLength": 4, // Set number of rows per page
                // language: {
                //     paginate: {
                //         previous: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>',
                //         next: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>'
                //     }
                // }
            });
        });
        $(document).ready(function() {
            $('.table.dataTable').DataTable({
                scrollY: '250px',
                scrollCollapse: true,
                ordering: false,
                paging: false,
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
