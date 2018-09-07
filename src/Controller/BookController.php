<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TypeConverter;
use App\Service\ProjectPositioner;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Cocur\Slugify\Slugify;
use App\Entity\Book;
use App\Form\BookType;


class BookController extends Controller
{
    public function index()
    {
        $bookRepo = $this->getDoctrine()->getRepository(Book::class);
        $books = $bookRepo->findAll(['position' => 'ASC']);

        return $this->render('home/books.html.twig', [
            'books' => $books,
        ]);
    }

    public function adminBooks(Request $request, FileUploader $fileUploader, TypeConverter $typeConverter)
    {
        $em = $this->getDoctrine()->getManager();
        
        $bookRepo = $this->getDoctrine()->getRepository(Book::class);
        $books = $bookRepo->findAll(['position' => 'ASC']);

        $jsonBooks = $typeConverter->jsonConvert($books);

        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $book->getImage();
            $directory = $this->getParameter('thumbnail_directory');
            $fileName = $fileUploader->upload($file, $directory);
            $book->setImage($fileName);
            $book->setPosition(count($books)+1);

            $title = $book->getTitle();
            $slugify = new Slugify();
            $book->setSlug($slugify->slugify($title));

            $em->persist($book);
            $em->flush();

            return $this->redirect($this->generateUrl('AdminBooksRoute'));
        }

        return $this->render('admin/adminProjects.html.twig', [
            'projects' => $jsonBooks,
            'form' => $form->createView(),

        ]);

    }
}
