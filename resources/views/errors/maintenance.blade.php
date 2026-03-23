<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ImperialVilla Portal Maintenance</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white flex items-center justify-center min-h-screen">

  <div class="text-center max-w-lg px-6">
    <img src="{{ asset('images/logo.png') }}" alt="ImperialVilla Logo" class="mx-auto w-24 mb-6 rounded-lg shadow-md">
    
    <h1 class="text-3xl font-bold text-green-400 mb-4">🛠️ Portal Temporarily Offline</h1>
    <p class="text-gray-300 mb-6">
      The ImperialVilla Pension Processing Portal is currently undergoing scheduled maintenance or administrative shutdown.
    </p>

    <p class="text-sm text-gray-400 mb-8">
      Please check back later. For urgent inquiries, contact us:
    </p>

    <div class="bg-gray-800 p-4 rounded-lg shadow-lg text-left text-sm mb-6">
      <p><strong>Email:</strong> support@imperialvilla.com</p>
      <p><strong>Phone:</strong> +234 800 123 4567</p>
    </div>

    <a href="/" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-md transition">
      🔁 Retry Now
    </a>

    <p class="mt-8 text-xs text-gray-500">
      &copy; {{ now()->year }} ImperialVilla Pension Processing — All Rights Reserved.
    </p>
  </div>

</body>
</html>
