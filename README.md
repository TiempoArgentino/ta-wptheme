# **GENOSHA Wordpress Base Theme**

# Scripts

- `yarn install`: Installs the required dependencies
- `yarn workspaces run start`: Starts development mode for all modules
- `yarn workspaces run build`: Run builds scripts for all modules

# Modules

Choose what functionalities you want to use or not by loading or removing modules
on execution time.

# Entities

Posts and taxonomies

## Admin Table Columns

Add or remove columns from the posts or taxonomies tables.

## Metaboxes and Metadata Inputs

Add controls to manage meta values for posts, terms, attachments and menu items
admin pages, or options in the customizer.

# Filters/Actions Manager

Add actions and filters hooks that can be removed by ID, allowing the use of
anonymous functions.

# Components System

Create reusable components to use in your templates, following a MVC architecture.

Enqueue related scripts and styles only if the component is used.

Specify default parameters for the component.

Define dependencies for your component to load necessary scripts from other components.

Component files can be overridden by the child theme
