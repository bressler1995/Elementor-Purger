# Elementor Purger Plugin

The Elementor Purger plugin is a very simple plugin for Wordpress that does the following:

- Adds a CRON scheduler that runs every 5 minutes
- Clears Elementor cache as specificed in Elementor documentation
- Clears cache on website taking into account popular cache plugins such as Siteground Cache, WP Rocket, W3 Total Cache, and WP Fastest Cache

## Purpose

Customer Salazar Digital observed websites using certain internal tooling in combination with Elementor would break the front end.  This temporary solution mitigates this although not ideal in the long term.

## Usage and Installation

Install it in the plugins screen of the Wordpress dashboard.  No additional configuration is needed.