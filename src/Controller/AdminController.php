<?php
namespace Application\Controller;

use Framework\Controller;

class AdminController extends Controller
{
    private $model_book;
    private $model_chapter;
    private $model_user;
    private $form_book;
    private $form_chapter;
    private $form_user;
    private $book_handler;
    private $chapter_handler;
    private $user_handler;

    public function __construct(\Application\Form\User\AddForm $form_user,\Application\Form\Chapter\AddForm $form_chapter,\Application\Form\Book\AddForm $form_book,\Application\Model\User $model_user,\Application\Model\Chapter $model_chapter,\Application\Model\Book $model_book,\Application\Handler\BookHandler $book_handler,\Application\Handler\ChapterHandler $chapter_handler,\Application\Handler\UserHandler $user_handler) {
        $this->model_book = $model_book;
        $this->model_chapter = $model_chapter;
        $this->model_user = $model_user;
        $this->form_book = $form_book;
        $this->form_chapter = $form_chapter;
        $this->form_user = $form_user;
        $this->book_handler = $book_handler;
        $this->chapter_handler = $chapter_handler;
        $this->user_handler = $user_handler;
    }

    public function panel()
    {   
        return $this->render('admin.twig', array(
            'title' => 'Panel Admin'
        ));
    }

    public function book($request)
    {        
        $this->form_book->handle($request);

        if ($this->form_book->isSubmitted()) {
            if (isset($request->getParsedBody()['delete'])) {
                $this->book_handler->delete($this->form_book->getData());
                return $this->redirect('/blogv3/admin/book/');
            }

            if ($this->form_book->isValid()) {
                if (isset($request->getParsedBody()['edit'])) {
                    $this->book_handler->edit($this->form_book->getData());
                    return $this->redirect('/blogv3/admin/book/');
                }

                $this->book_handler->add($this->form_book->getData());
                return $this->redirect('/blogv3/admin/book/');
            }
        }
        
        return $this->render('admin/book.twig', array(
            'title' => 'Manage Books',
            'books' => $this->book_handler->list(),
            'form' => $this->form_book
        ));
    }

    public function chapter($request)
    {
        
        $this->form_chapter->handle($request);
        
        if ($this->form_chapter->isSubmitted()) {
            if (isset($request->getParsedBody()['delete'])) {
                $this->chapter_handler->delete($this->form_chapter->getData());
                return $this->redirect('/blogv3/admin/chapter/');
            }

            if ($this->form_chapter->isValid()) {
                if (isset($request->getParsedBody()['edit'])) {
                    $this->chapter_handler->edit($this->form_chapter->getData());
                    return $this->redirect('/blogv3/admin/chapter/');
                }

                $this->chapter_handler->add($this->form_chapter->getData());
                return $this->redirect('/blogv3/admin/chapter/');
            }
        }

        return $this->render('admin/chapter.twig', array(
            'title' => 'Manage Chapters',
            'books' => $this->book_handler->list(),
            'chapters' => $this->chapter_handler->list(),
            'form' => $this->form_chapter
        ));
    }

    public function user($request)
    {
        $this->form_user->handle($request);

        if ($this->form_user->isSubmitted()) {
            if (isset($request->getParsedBody()['delete'])) {
                $this->user_handler->delete($this->form_user->getData());
                return $this->redirect('/blogv3/admin/user/');
            }

            if ($this->form_user->isValid()) {
                if (isset($request->getParsedBody()['edit'])) {
                    $this->user_handler->edit($this->form_user->getData());
                    return $this->redirect('/blogv3/admin/user/');
                }

                $this->user_handler->add($this->form_user->getData());
                return $this->redirect('/blogv3/admin/user/');
            }
        }

        return $this->render('admin/user.twig', array(
            'title' => 'Manage Users',
            'users' => $this->user_handler->list(),
            'form' => $this->form_user
        ));
    }
}
