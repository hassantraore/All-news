<?php


namespace App\DataTransfertObject;
use Symfony\Component\Validator\Constraints as Assert;

class Credentials
{
    /**
     * @var string|null
     * Assert/NotBlank
     */
private ?string $username =null;

    /**
     * @var string|null
     * Assert/NotBlank
     */
private ?string $passwords=null;

    /**
     * Credentials constructor.
     * @param string|null $username
     */
    public function __construct(?string $username=null)
    {
        $this->username = $username;
    }


    /**
     * @return string|null
     */
    public function getPasswords(): ?string
    {
        return $this->passwords;
    }

    /**
     * @param string|null $passwords
     */
    public function setPasswords(?string $passwords): void
    {
        $this->passwords = $passwords;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }


}