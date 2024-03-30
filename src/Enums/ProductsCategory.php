<?php 
namespace App\Enums;

enum ProductsCategory: string {
    case FOOD = 'food';
    case DRINK = 'drink';
    case CLOTHES = 'clothes';
    case ELECTRONICS = 'electronics';
    case BOOKS = 'books';
    case TOYS = 'toys';
    case TOOLS = 'tools';
    case SPORTS = 'sports';
    case BEAUTY = 'beauty';
    case FURNITURE = 'furniture';
    case OTHER = 'other';
    
}