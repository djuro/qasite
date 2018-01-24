<?php

namespace AppBundle\Service\Application;
use AppBundle\Entity\User;
use AppBundle\View\AuthorView;

trait AuthorViewFactory {
    
    /**
     * @param User $author
     * @return AuthorView
     */
    function createAuthorView(User $author) {
        $authorView = new AuthorView($author->getId(), $author->getName(), $author->getSurname());
        return $authorView;
    }
}
