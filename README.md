# Octoshop - A Shop Plugin for October CMS

Pretty much does what it says on the tin. Octoshop adds all the basic functionality
needed to sell products from your website running on October CMS. Still in its infancy,
it's fairly barebones right now, though the process from browsing to buying is already
covered. Payments are powered by Stripe JS for now, letting me spend more time worrying
about the things that matter most.


## Demo

Frontend: http://octoshop.demo.dsdev.io/
Backend: http://octoshop.demo.dsdev.io/backend/

Username and password for the backend are both `admin`.


## Documentation

Not yet... Check out the demo, browse the source, and have a gander at the optional
[theme](https://github.com/dshoreman/octoshop-theme) if you want to play about.


## Installation

Installing Octoshop is fairly simple, despite not yet being available in the October CMS Plugin store.
All you need to do is clone this repository, fire off composer and run the migrations:

```
cd /path/to/october-cms
mkdir -p plugins/dshoreman
git clone https://github.com/dshoreman/oc-shop.git plugins/dshoreman/shop
cd plugins/dshoreman/shop; composer install; cd -
php artisan october:up
```

Once you've completed the terminal bits, all that's left is to setup your Stripe API keys
in the backend. You'll find them in the Shop section of the Settings page.

If you'd like to get started by trying the theme too, clone it into themes/octoshop.
