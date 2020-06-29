<?php

namespace App\RemoteProxy;

use App\RemoteProxy\Annotation\Endpoint;

interface BooksInterface
{
    /**
     * Return Books
     * @Endpoint(path="/books")
     */
    public function getBooks();


    /**
     * Return books details
     * @Endpoint(path="/books/:id")
     *
     * @param $id
     * @return mixed
     */
    public function getBook($id);

    /**
     * Return authors of a book
     * @Endpoint(path="/books/:id/authors")
     * @param $id
     * @return mixed
     */
    public function getAuthors($id);
}
