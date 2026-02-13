# Frequently Asked Questions (FAQ)

## General Questions

### Is this framework free?

**Yes, completely free!** This framework is open-source and licensed under the MIT License. You can use it for:
- Learning PHP and MVC patterns
- Personal projects
- Commercial applications
- Teaching and educational purposes

There are no hidden costs, subscriptions, or premium features. Everything is free and open-source.

### What does "Model" mean in this framework?

The term "Model" in this framework refers to the **M** in MVC (Model-View-Controller). Models are PHP classes that interact with the database. All models in this framework are free and included:

- **Model.php** - Base model class with CRUD operations
- **User.php** - User accounts and authentication
- **Log.php** - Application activity logging
- **ThemeSetting.php** - Theme customization
- **MenuItem.php** - Navigation menu management
- **HomepageSetting.php** - Homepage content
- **AboutContent.php** - About page content
- **PurchaseContent.php** - Purchase page content
- **GalleryImage.php** - Image gallery management

All models extend the base `Model` class and provide database operations like `find()`, `all()`, `create()`, `update()`, and `delete()`.

## Usage Questions

### Can I use this for commercial projects?

**Yes!** The MIT License allows you to use this framework for any purpose, including commercial applications. You can modify it, distribute it, and use it in proprietary software without any restrictions.

### Do I need to pay for support or updates?

**No.** This is a community-driven educational project. While there's no paid support, you can:
- Open issues on GitHub for bugs or questions
- Contribute improvements via pull requests
- Fork the repository and modify it for your needs

### What are the system requirements?

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache or Nginx web server (or Docker)
- Composer (for autoloading)

### Is this production-ready?

This framework is designed as an **educational tool** to help you understand MVC patterns and PHP framework architecture. While it includes many production features (authentication, CSRF protection, rate limiting, etc.), it's intentionally minimal to keep the codebase easy to understand.

Before using in production, review the security checklist in the README and consider:
- Additional security hardening
- Comprehensive testing
- Performance optimization
- Error monitoring
- Regular updates

## Technical Questions

### How do I add my own models?

1. Create a new PHP file in `app/Models/`
2. Extend the base `Model` class
3. Define your table name and fillable fields
4. Use it in your controllers

Example:
```php
<?php
namespace App\Models;

class Product extends Model
{
    protected string $table = 'products';
    protected array $fillable = ['name', 'price', 'description'];
    protected bool $timestamps = true;
}
```

### Can I contribute to this project?

**Yes!** Contributions are welcome. You can:
- Report bugs or suggest features via GitHub issues
- Submit pull requests with improvements
- Share your experience using the framework
- Help improve documentation

### Where can I get help?

- Read the [README.md](README.md) for setup instructions
- Check the [AI coding instructions](.github/copilot-instructions.md) for development patterns
- Review the code comments and examples
- Open an issue on GitHub for specific questions

## License Questions

### Can I remove the copyright notice?

The MIT License requires that you include the copyright notice and license text in all copies or substantial portions of the software. However, you can add your own copyright for modifications you make.

### Can I sell products built with this framework?

**Yes!** You can build and sell commercial applications using this framework. The MIT License does not require you to share your application's source code or pay any fees.

### Do I need to credit this framework in my project?

While not required by the MIT License, it's appreciated if you mention that your project uses this framework. However, you're not obligated to do so.

## Getting Started

### How do I install this framework?

1. Clone or download the repository
2. Run `composer install` (if using Composer)
3. Copy `.env.example` to `.env` and configure your database
4. Run the database initialization scripts
5. Point your web server to the `public/` directory

See the [README.md](README.md) for detailed instructions.

### Is there a video tutorial?

Currently, there are no official video tutorials. However, the code is well-documented and includes extensive comments. The framework follows standard MVC patterns, so general PHP MVC tutorials will be helpful.

### What's the difference between this and Laravel/Symfony?

This framework is **intentionally minimal** for educational purposes. Unlike Laravel or Symfony:
- Smaller codebase (easier to understand)
- No dependency on external packages (except PDO)
- Focused on core MVC concepts
- Direct access to all code (no "magic")

For production applications, consider using established frameworks like Laravel or Symfony which offer more features, community support, and enterprise-grade stability.
