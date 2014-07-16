# Kohana Boilerplate

Structure for enterprise-grade websites for Kohana Framework. Already thought-out.

# What is boilerplate?

Kohana Boilerplate is neither a library nor an another framework. It's a *boilerplate*, stuff you use as a starting
point for your work.

As a consequence of this, do not bother thinking about "updates" or "future versions" of KB after you started your
project over it. Just adapt it to your needs as you wish.

# Requirements

- PHP 5.3
- Apache2 mod rewrite (or nginx similar config) for 'app' and 'public' directories separation

# Features

KB uses a structure that a bit different from original Kohana. All framework files are stored in 'app' directory that
isolated from any public access. All public files are stored in 'public' directory (css, js, html etc.). Here you can
found original Kohana index.php - the only php file accessible externally.