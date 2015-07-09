# monstra-cms-mailtoguard
===================

Protect your mailto from spam in monstra CMS

Usage:

Shordcode for content
```
{mailtoguard email="admin@site.org"}
```
or if you want to include a CC email address
```
{mailtoguard email="admin@site.org" cc="cc@site.org"}
```
Code for templates
```
<?php mailtoguard::display('admin@site.org'); ?>
```
or if you want to include a CC email address
```
<?php mailtoguard::display('admin@site.org','cc@site.org'); ?>
```