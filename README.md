## Development

Running project on local machine for development and testing pusposes.

### Prerequisites

- [Node 14+](https://nodejs.org)

### Configuration

Run `npm install` for installing theme dependencies.

Create .env file in your theme root directory with next line of code.
```sh
BROWSER_SYNC_PROXY=your_local_url
```

### Available Scripts
- `npm run dev` Starts the development server with BrowserSync and watches for file changes in real-time. 
- `npm run build` Compiles and optimizes the project for production.

### Project Structure

- **`assets`** - styles, scripts, images, fonts
- **`node_modules`** - Dependencies installed via yarn (gitignore)
- **`template-parts`** - templates
- **`utils`** - WP and plugins configuration
  - **`acf`** - ACF configuration in PHP and JSON
  - **`cpt`** - Custom Post configuration
- **`functions.php`**
- **`index.php`** - default content file
- **`header.php`** - header file
- **`footer.php`** - footer file
- **`single.php`** - default blogpost file
- **`404.php`** - error 404 file
- **`readme.md`** - this readme
- **`tailwind.config.js`** - Tailwind config
- **`package.json`** - project dependencies and scripts
- **`style.css`** - basic info about theme'
