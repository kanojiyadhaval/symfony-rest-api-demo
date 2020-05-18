<?php
 namespace App\Entity;
 use Doctrine\ORM\Mapping as ORM;
 use Symfony\Component\Validator\Constraints as Assert;
 /**
  * @ORM\Entity(repositoryClass="App\Repository\BooksRepository")
  * @ORM\Table(name="books")
  * @ORM\HasLifecycleCallbacks()
  */
 class Books implements \JsonSerializable {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(type="string"), length=100
   *
   */
  private $title;
  /**
   * @ORM\Column(type="text")
   */
  private $description;

  /**
   * Price of the option (in cents)
   *
   * @ORM\Column(type="integer", nullable=true)
   */
  protected $price = 0;

  /**
   * @ORM\Column(type="datetime")
   */
  private $create_date;

   /**
   * @ORM\Column(type="string")
   */
  private $image;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="books")
   * @ORM\Column(type="integer")
   */
  private $author_id;

  /**
   * @return mixed
   */
  public function getId()
  {
   return $this->id;
  }
  /**
   * @param mixed $id
   */
  public function setId($id)
  {
   $this->id = $id;
  }
  /**
   * @return mixed
   */
  public function getTitle()
  {
   return $this->title;
  }
  /**
   * @param mixed $name
   */
  public function setTitle($title)
  {
   $this->title = $title;
  }
  /**
   * @return mixed
   */
  public function getDescription()
  {
   return $this->description;
  }
  /**
   * @param mixed $description
   */
  public function setDescription($description)
  {
   $this->description = $description;
  }

  /**
   * @return mixed
   */
  public function getCreateDate(): ?\DateTime
  {
   return $this->create_date;
  }

  /**
   * @param \DateTime $create_date
   * @return Books
   */
  public function setCreateDate(\DateTime $create_date): self
  {
   $this->create_date = $create_date;
   return $this;
  }

  /**
   * @param int $price
   */
  public function setPrice(?int $price): self
  {
      $this->price = $price;

      return $this;
  }

  /**
   * @return int
   */
  public function getPrice(): ?int
  {
      return $this->price;
  }

  /**
   * @return mixed
   */
  public function getImage()
  {
   return $this->image;
  }
  /**
   * @param mixed $id
   */
  public function setImage($image)
  {
   $this->image = $image;
  }

  /**
   * @return mixed
   */
  public function getAuthorId()
  {
   return $this->author_id;
  }
  /**
   * @param mixed $author_id
   */
  public function setAuthorId($author_id)
  {
   $this->author_id = $author_id;
  }

  /**
   * @throws \Exception
   * @ORM\PrePersist()
   */
  public function beforeSave(){

   $this->create_date = new \DateTime('now', new \DateTimeZone('Africa/Casablanca'));
  }



  /**
   * Specify data which should be serialized to JSON
   * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
   * @return mixed data which can be serialized by <b>json_encode</b>,
   * which is a value of any type other than a resource.
   * @since 5.4.0
   */
  public function jsonSerialize()
  {
   return [
    "title" => $this->getTitle(),
    "description" => $this->getDescription(),
    "price" => $this->getPrice()
   ];
  }
 }