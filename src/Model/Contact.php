<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;


class Contact
{

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     */
    protected $name;
    
    /**
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas un mail valide."
     * )
     */
    protected $email;
    
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=15)
     */
    protected $message;



	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): Contact
	{
		$this->name = $name;

		return $this;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail(string $email): Contact
	{
		$this->email = $email;

		return $this;
    }
    
    public function getMessage(): ?string
	{
		return $this->message;
	}

	public function setMessage(string $message): Contact
	{
		$this->message = $message;

		return $this;
	}
}