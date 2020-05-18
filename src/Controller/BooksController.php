<?php
 /**
  * Created by PhpStorm.
  * User: hicham benkachoud
  * Date: 02/01/2020
  * Time: 22:44
  */

 namespace App\Controller;


 use App\Entity\Books;
 use App\Repository\BooksRepository;
 use Doctrine\ORM\EntityManagerInterface;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\JsonResponse;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\Routing\Annotation\Route;

 /**
  * Class BooksController
  * @package App\Controller
  * @Route("/api", name="books_api")
  */
 class BooksController extends AbstractController
 {
  /**
   * @param BooksRepository $booksRepository
   * @return JsonResponse
   * @Route("/books", name="books", methods={"GET"})
   */
  public function getBooks(BooksRepository $booksRepository){
   $data = $booksRepository->findAll();
   
   return $this->response($data);
  }

  /**
   * @param Request $request
   * @param EntityManagerInterface $entityManager
   * @param BooksRepository $booksRepository
   * @return JsonResponse
   * @throws \Exception
   * @Route("/books", name="book_add", methods={"POST"})
   */
  public function addBook(Request $request, EntityManagerInterface $entityManager, BooksRepository $booksRepository){

   try{

    $user = $this->get('security.token_storage')->getToken()->getUser();
    $userId = $user->getId();

    if (!$userId){
     $data = [
      'status' => 404,
      'errors' => "User token not found",
     ];
     return $this->response($data, 404);
    }

    $request = $this->transformJsonBody($request);

    if (!$request || !$request->get('title') || !$request->request->get('description') || !$request->request->get('price') || !$request->request->get('image')){
     throw new \Exception();
    }

    $post = new Books();
    $post->setTitle($request->get('title'));
    $post->setDescription($request->get('description'));
    $post->setPrice($request->get('price'));
    $post->setImage($request->get('image'));
    $post->setAuthorId($userId);
    $entityManager->persist($post);
    $entityManager->flush();

    $data = [
     'status' => 200,
     'success' => "Books added successfully",
    ];
    return $this->response($data);

   }catch (\Exception $e){
    
    $data = [
     'status' => 422,
     'errors' => "Data no valid",
    ];
    return $this->response($data, 422);
   }

  }


  /**
   * @param BooksRepository $booksRepository
   * @param $id
   * @return JsonResponse
   * @Route("/books/{id}", name="book_get", methods={"GET"})
   */
  public function getBook(BooksRepository $booksRepository, $id){
   $post = $booksRepository->find($id);

   if (!$post){
    $data = [
     'status' => 404,
     'errors' => "Books not found",
    ];
    return $this->response($data, 404);
   }
   return $this->response($post);
  }

  /**
   * @param Request $request
   * @param EntityManagerInterface $entityManager
   * @param BooksRepository $booksRepository
   * @param $id
   * @return JsonResponse
   * @Route("/books/{id}", name="books_put", methods={"PUT"})
   */
  public function updateBook(Request $request, EntityManagerInterface $entityManager, BooksRepository $booksRepository, $id){

   try{
    $post = $booksRepository->find($id);

    $user = $this->get('security.token_storage')->getToken()->getUser();
    $userId = $user->getId();

    if (!$userId){
     $data = [
      'status' => 404,
      'errors' => "User token not found",
     ];
     return $this->response($data, 404);
    }


    if (!$post){
     $data = [
      'status' => 404,
      'errors' => "Post not found",
     ];
     return $this->response($data, 404);
    }

    $request = $this->transformJsonBody($request);

    if (!$request || !$request->get('title') || !$request->request->get('description') || !$request->request->get('price') || !$request->request->get('image')){
     throw new \Exception();
    }

    $post->setTitle($request->get('title'));
    $post->setDescription($request->get('description'));
    $post->setPrice($request->get('price'));
    $post->setImage($request->get('image'));
    $post->setAuthorId($userId);
    $entityManager->flush();

    $data = [
     'status' => 200,
     'errors' => "Books updated successfully",
    ];
    return $this->response($data);

   }catch (\Exception $e){
    $data = [
     'status' => 422,
     'errors' => "Data no valid",
    ];
    return $this->response($data, 422);
   }

  }


  /**
   * @param BooksRepository $booksRepository
   * @param $id
   * @return JsonResponse
   * @Route("/books/{id}", name="books_delete", methods={"DELETE"})
   */
  public function deleteBook(EntityManagerInterface $entityManager, BooksRepository $booksRepository, $id){
   $post = $booksRepository->find($id);

   if (!$post){
    $data = [
     'status' => 404,
     'errors' => "Books not found",
    ];
    return $this->response($data, 404);
   }

   $entityManager->remove($post);
   $entityManager->flush();
   $data = [
    'status' => 200,
    'errors' => "Books deleted successfully",
   ];
   return $this->response($data);
  }





  /**
   * Returns a JSON response
   *
   * @param array $data
   * @param $status
   * @param array $headers
   * @return JsonResponse
   */
  public function response($data, $status = 200, $headers = [])
  {
   return new JsonResponse($data, $status, $headers);
  }

  protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
  {
   $data = json_decode($request->getContent(), true);

   if ($data === null) {
    return $request;
   }

   $request->request->replace($data);

   return $request;
  }

 }