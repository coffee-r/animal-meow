<?php

namespace App\CoffeeR\Post\Domain;

interface TweetRepositoryInterface{
    function tweet(String $message): Tweet;
}