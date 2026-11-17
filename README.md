Sonora · Aplicación web de música

Requisitos previos

- PHP 8.2 o superior
- Composer
- Node.js y NPM
- Servidor local (Laravel Herd, Laragon o `php artisan serve`)

Pasos de instalación y ejecución

1. Clona este repositorio y entra en la carpeta del proyecto:
    git clone <https://github.com/Kasschool/sonora.git>
   cd sonora-laravel

2. Instala las dependencias de PHP y JavaScript:
   composer install
   npm install

3. Configura el archivo de entorno y la clave de la aplicación:
   cp .env.example .env
   php artisan key:generate


4. Crea la base de datos (SQLite por defecto), ejecuta las migraciones y siembra las 8 pistas inventadas:
  php artisan migrate --seed


5. Inicia el servidor de compilación de Vite (Tailwind CSS y JavaScript):
   npm run dev

6. Abre la aplicación en tu navegador:
   - Con Laravel Herd: `http://sonora-laravel.test`
   - Con servidor integrado de Laravel (`php artisan serve`): `http://127.0.0.1:8000