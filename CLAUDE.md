# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Frontend Development
- `npm run dev` - Start Vite development server with hot reload
- `npm run build` - Build production assets

### Backend Development
- `php artisan serve` - Start Laravel development server
- `php artisan migrate` - Run database migrations
- `php artisan db:seed` - Run database seeders
- `php artisan tinker` - Open Laravel REPL

### Testing
- `php artisan test` - Run PHPUnit tests
- `./vendor/bin/phpunit` - Alternative test runner

### Code Quality
- `php artisan pint` - Laravel Pint code formatter (available via composer)

## Architecture Overview

This is a Laravel 11 application with Vue.js 3 frontend using Inertia.js-like SPA architecture.

### Backend Structure
- **Laravel 11** with PHP 8.2+
- **Modular architecture** using `nwidart/laravel-modules` package
- **Permission system** using Spatie Laravel Permission
- **File uploads** handled via Intervention Image
- **Custom helper functions** in `app/Helpers/CommonHelper.php`

### Frontend Structure
- **Vue.js 3** with Composition API
- **Element Plus** UI components with auto-import
- **Pinia** for state management
- **Vue Router** for client-side routing
- **Vue I18n** for internationalization
- **TanStack Query** for API state management
- **CASL** for frontend permissions

### Key Architectural Patterns

**Module System**: The application uses Laravel Modules for organizing features:
- Core modules stored in `/Modules/` directory
- Dynamic route loading from modules (currently commented out in router)
- Each module can have its own controllers, models, and frontend routes

**Authentication & Authorization**:
- Spatie Laravel Permission for role-based access control
- Frontend permission checking using CASL
- Route-level permission requirements in Vue Router

**File Structure**:
- Controllers organized by feature (`Employee/`, `Settings/`)
- Models have subdirectories for related entities (`Employee/`, `Settings/`)
- Frontend components in logical groups (`Form/`, `Chart/`, `Modal/`)
- Shared composables for common functionality

**API Architecture**:
- RESTful API endpoints
- Form request validation classes
- Resource transformers for API responses
- Middleware for authentication and localization

### Database & Models

**Employee Management System**:
- Core `Employee` model with related models in `Employee/` subdirectory
- Supporting models: `Agreement`, `Attachment`, `BankAccount`, `Certification`, `Education`, `Experience`, `Family`, `Insurance`, `Medical`
- Settings models: `Department`, `Expertise`, `Grade`, `JobPosition`
- Nested set pattern for hierarchical data (likely departments)

### Frontend State Management

**Stores** (Pinia):
- `auth.js` - Authentication state
- `base.js` - Application initialization and global state
- `user.js` - User-specific data

**Key Features**:
- Multi-language support with locale switching
- File upload with image processing
- Permission-based UI rendering
- Department tree structure display
- Employee management with multiple data sections

### Build Process

**Vite Configuration**:
- SCSS and JavaScript bundling
- Vue.js with Element Plus auto-import
- Path aliases: `@` for `resources/js`, `~modules` for modules
- Development server with HTTPS support
- Manual chunk splitting for better performance

## Development Notes

### File Upload System
The application uses a custom `uploadFile()` helper function that:
- Processes both regular files and images
- Uses Intervention Image for image optimization
- Stores files in `/public/uploads/` directory
- Returns relative paths for database storage

### Permission System
- Backend: Spatie Laravel Permission with roles and permissions
- Frontend: CASL for reactive permission checking
- Route guards check permissions before navigation

### Localization
- Backend: Laravel localization with JSON files
- Frontend: Vue I18n with dynamic locale loading
- Locale switching affects both backend and frontend

### Module Development
When working with modules, note that:
- Module routes are dynamically loaded (currently disabled)
- Each module should follow Laravel Module conventions
- Frontend module routes should be in `resources/routes.js`