<?php
namespace App\Entity;

use App\Entity\Sonata\CoverImage;
use App\Entity\Sonata\Pdf;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class IndexInfo
 * @package App\Entity
 *
 * @ORM\Entity()
 */
class IndexInfo
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var CoverImage
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Sonata\CoverImage", cascade={"persist", "remove"}, orphanRemoval=true)
     *
     * @Assert\NotNull(message="L'image de bio est obligatoire")
     * @Assert\Type(
     *     type="object",
     *     message="L'image de biographie doit être du type CoverImage."
     * )
     */
    private $bioImage;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     *
     * @Assert\NotBlank(message="Veuillez renseigner une biographie")
     * @Assert\Type(
     *     type="string",
     *     message="Le contenu doit être une chaine de caractères"
     * )
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text")
     */
    private $rawContent;

    /**
     * @var int
     *
     * @ORM\Column(name="phone_number", type="bigint", columnDefinition="INT(10) UNSIGNED ZEROFILL")
     *
     * @Assert\NotNull(message="Veuillez renseigner un numéro de téléphone")
     * @Assert\Type(
     *     type="numeric",
     *     message="Le numéro de téléphone doit être une valeur numérique"
     * )
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string")
     *
     * @Assert\NotBlank(message="Veuillez renseigner une ville")
     * @Assert\Type(
     *     type="string",
     *     message="La ville doit être une chaine de caractères"
     * )
     */
    private $city;

    /**
     * @var Pdf
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Sonata\Pdf", cascade={"persist", "remove"}, orphanRemoval=true)
     *
     * @Assert\NotNull(message="Veuillez renseigner un CV de level design")
     * @Assert\Type(
     *     type="object",
     *     message="Le CV doit être un objet de type PDF"
     * )
     */
    private $ldCv;

    /**
     * @var Pdf
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Sonata\Pdf", cascade={"persist", "remove"}, orphanRemoval=true)
     *
     * @Assert\NotNull(message="Veuillez renseigner un CV de game design")
     * @Assert\Type(
     *     type="object",
     *     message="Le CV doit être un objet de type PDF"
     * )
     */
    private $gdCv;

    /**
     * @var EventDispatcher
     */
    private $contentFormatter;

    public function __construct()
    {
        $this->setName('Informations index');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return CoverImage
     */
    public function getBioImage()
    {
        return $this->bioImage;
    }

    /**
     * @param CoverImage $bioImage
     */
    public function setBioImage(CoverImage $bioImage): void
    {
        $this->bioImage = $bioImage;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * @param string $rawContent
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;
    }

    /**
     * @return int
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param int $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return Pdf
     */
    public function getLdCv()
    {
        return $this->ldCv;
    }

    /**
     * @param Pdf $ldCv
     */
    public function setLdCv(Pdf $ldCv): void
    {
        $this->ldCv = $ldCv;
    }

    /**
     * @return Pdf
     */
    public function getGdCv()
    {
        return $this->gdCv;
    }

    /**
     * @param Pdf $gdCv
     */
    public function setGdCv(Pdf $gdCv): void
    {
        $this->gdCv = $gdCv;
    }

    /**
     * @return mixed
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * @param mixed $contentFormatter
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}
