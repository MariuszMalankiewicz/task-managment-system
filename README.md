# Task Managment System

## Table of contents
* [General info](#general-info)
* [Principles](#Principles)
* [Technologies](#technologies)
* [Hardware_requirements](#hardware_requirements)
* [Setup](#setup)

## General info
The task management system is a RESTful API with an MVC structure and repository and service pattern.

restful api allows for authentication, an authenticated user can manage their tasks, add, display, update and delete.

### contains:
* functional tests verify correct operation between components
* unit tests verify the correct operation of individual methods
* sanctum authentication system 
* policy authorization system
* data validation
* CRUD is an acronym for (cread read update delete)
* relationships
* service provider
* interface and his implementation

## Principles
* Solid
* Dry
* Kiss

## Technologies
Project is created with:
* Laravel 11

## Hardware_requirements
* Php 8.2
* Composer

## Setup
* Clone this repo to your desktop
* Run cp .env.example .env or copy .env.example .env
* Run composer install
* Run php artisan key:generate
* Run php artisan migrate
* Run php artisan serve
