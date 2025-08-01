# Overview

CrownOpportunities is a modern UK job board application specifically designed to connect African professionals with job opportunities in the United Kingdom. The platform focuses on sectors like construction, healthcare, hospitality, and skilled trades, with particular emphasis on visa sponsorship opportunities. 

**Current Status**: Successfully converted from Node.js/React to Laravel PHP (August 1, 2025) to be compatible with HostAfrica hosting which only supports PHP. The Laravel version maintains all original functionality while adapting to PHP/Laravel architecture patterns.

# User Preferences

Preferred communication style: Simple, everyday language.

# System Architecture

## Current Laravel Architecture (August 2025)
- **Framework**: Laravel 10.3.3 with PHP 8.1
- **Frontend**: Blade templates with Tailwind CSS and Alpine.js for interactivity
- **Routing**: Laravel web routes and API routes
- **Database**: PostgreSQL with Eloquent ORM
- **File Uploads**: Laravel storage system with public disk configuration
- **Authentication**: Laravel Sanctum for API authentication (admin features)
- **Validation**: Laravel request validation with comprehensive rules

## Previous Node.js Architecture (Converted)
- **Framework**: React 18 with TypeScript using Vite as the build tool
- **UI Framework**: shadcn/ui component library built on Radix UI primitives
- **Styling**: Tailwind CSS with custom CSS variables for brand theming
- **Routing**: Wouter for lightweight client-side routing
- **State Management**: TanStack Query (React Query) for server state management
- **Form Handling**: React Hook Form with Zod validation
- **Backend**: Node.js with Express.js framework and TypeScript

## Database Design (Converted to Laravel)
- **Database**: PostgreSQL (compatible with HostAfrica hosting)
- **ORM**: Laravel Eloquent ORM with UUID primary keys
- **Migrations**: Laravel migration system for schema management
- **Core Tables**:
  - `jobs` - Job postings with company details, requirements, and metadata
  - `applications` - User applications linked to jobs with personal information and file uploads
  - `testimonials` - Success stories with photos and ratings
  - `messages` - Contact form submissions
  - `categories` - Job categories with descriptions and GIF icons
  - `users` - Admin authentication system

## Authentication & Authorization
- **Admin System**: Simple username/password authentication for administrative functions
- **Session Management**: Token-based authentication for admin routes
- **Access Control**: Protected admin endpoints for job management, application review, and testimonial curation

## File Management
- **Storage**: Local file system with organized upload directory structure
- **File Types**: Support for PDF/DOC/DOCX for CVs and various image formats for photos
- **File Serving**: Static file serving with proper CORS headers
- **Upload Limits**: 10MB file size limit with file type validation

## Development Environment
- **Build System**: Vite for frontend bundling with esbuild for backend compilation
- **Development Server**: Hot module replacement for frontend, nodemon-like functionality for backend
- **Type Safety**: Full TypeScript coverage across frontend, backend, and shared schemas
- **Code Quality**: Consistent import/export patterns and modular component structure

# External Dependencies

## Core Framework Dependencies
- **@neondatabase/serverless** - PostgreSQL serverless database connection
- **drizzle-orm** & **drizzle-kit** - Type-safe ORM and migration tools
- **@tanstack/react-query** - Server state management and caching
- **react-hook-form** & **@hookform/resolvers** - Form handling with validation
- **zod** & **drizzle-zod** - Schema validation and type inference

## UI Component Libraries
- **@radix-ui/react-*** - Comprehensive set of accessible UI primitives
- **lucide-react** - Icon library for consistent iconography
- **tailwindcss** - Utility-first CSS framework
- **class-variance-authority** & **clsx** - Conditional styling utilities

## Backend Dependencies
- **express** - Web application framework
- **multer** - File upload handling middleware
- **ws** - WebSocket library for Neon database connection
- **connect-pg-simple** - PostgreSQL session store (configured but not actively used)

## Development Tools
- **vite** & **@vitejs/plugin-react** - Frontend build tooling
- **esbuild** - Fast backend compilation
- **tsx** - TypeScript execution for development
- **@replit/vite-plugin-runtime-error-modal** - Development error overlay
- **@replit/vite-plugin-cartographer** - Replit-specific development features

## Utility Libraries
- **date-fns** - Date manipulation and formatting
- **wouter** - Lightweight routing for React applications
- **nanoid** - Unique ID generation for various use cases