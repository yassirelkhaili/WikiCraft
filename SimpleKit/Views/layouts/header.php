<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $cssurl ?>">
    <script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"},
            main_header: '#1F2937',
            border_color: '#374151',
            main_background_color: '#111827'
          }
        }
      }
    }
  </script>
    <title><?= $pageTitle ?></title>
</head>
<body>
<header class="flex px-6 justify-between items-center h-20 border-b-[1px] border-border_color bg-main_header">
<div>
    <img src="../../public/frontend/src/images/brandlogo.webp" alt="WebCraft logo" class="h-8 w-28">
</div>
<div class="flex justify-center items-center gap-3">
<button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded text-sm px-5 py-2.5 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Sign Up</button>
<button class="bg-blue-500 hover:bg-blue-600 text-slate-50 font-bold py-2 px-4 rounded focus:border-4 focus:border-blue-200 border-blue-700">
  Register
</button>
</div>
</header>