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
<body class="bg-main_background_color">
<header class="absolute w-full flex px-6 justify-between items-center h-20 border-b-[1px] border-border_color bg-main_header">
<div>
    <img src="../../public/frontend/src/images/brandlogo.webp" alt="WebCraft logo" class="h-8 w-56">
</div>
<div class="flex justify-center items-center gap-3">
<?php if (isset($_SESSION["session_token"])): ?>
  <?php if ($_SESSION['user_role'] === 'admin'): ?>
    <a href="/dashboard">
      <button class="bg-blue-500 hover:bg-blue-600 text-slate-50 font-bold py-2 px-4 rounded focus:ring-4 focus:border-blue-200 border-blue-700">
        Dashboard
      </button>
    </a>
  <?php else: ?>
    <a href="/craftwiki">
      <button class="bg-blue-500 hover:bg-blue-600 text-slate-50 font-bold py-2 px-4 rounded focus:ring-4 focus:border-blue-200 border-blue-700">
        Craft
      </button>
    </a>
  <?php endif; ?>
  
  <a href="/logout">
    <button type="button" class="border border-blue-700 focus:ring-4 font-medium rounded text-sm px-5 py-2.5 text-center text-slate-50">
      Logout
    </button>
  </a>
<?php else: ?>
  <a href="/login">
    <button type="button" class="border border-blue-700 focus:ring-4 font-medium rounded text-sm px-5 py-2.5 text-center text-slate-50">
      Sign In
    </button>
  </a>
  <a href="/register">
    <button class="bg-blue-500 hover:bg-blue-600 text-slate-50 font-bold py-2 px-4 rounded focus:ring-4 focus:border-blue-200 border-blue-700">
      Register
    </button>
  </a>
<?php endif; ?>
</a>
</div>
</header>