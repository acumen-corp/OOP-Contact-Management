<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {{ get_title() }}
        {{ stylesheet_link('css/bootstrap.min.css') }}
        {{ stylesheet_link('css/bootstrap-datepicker.min.css') }}
          {{ stylesheet_link('css/style.css') }}

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Your Contacts">
        <meta name="author" content="Acumen Consulting">
    </head>
    <body>
        {{ content() }}
        {{ javascript_include('js/jquery.min.js') }}
        {{ javascript_include('js/bootstrap.min.js') }}

        {{ javascript_include('js/bootstrap-datepicker.min.js') }}
        {{ javascript_include('js/utils.js') }}
    </body>
</html>
