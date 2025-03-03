<?php
    class User {
    private int $id;
    private string $uuid;
    private string $khmerName;
    private string $latinName;
    private string $fatherName;
    private string $motherName;
    private DateTime $dateOfBirth;
    private string $placeOfBirth;
    private ?string $email; // Nullable
    private string $phoneNumber;
    private string $password;
    private string $profile;
    private string $major; // New field

   // constructor   
    public function __construct(
        int $id, string $uuid, string $khmerName, string $latinName,
        string $fatherName, string $motherName, DateTime $dateOfBirth, string $placeOfBirth,
        ?string $email, string $phoneNumber, string $password, string $profile, string $major
    ) {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->khmerName = $khmerName;
        $this->latinName = $latinName;
        $this->fatherName = $fatherName;
        $this->motherName = $motherName;
        $this->dateOfBirth = $dateOfBirth;
        $this->placeOfBirth = $placeOfBirth;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
        $this->profile = $profile;
        $this->major = $major;
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getUuid(): string {
        return $this->uuid;
    }

    public function getKhmerName(): string {
        return $this->khmerName;
    }

    public function getLatinName(): string {
        return $this->latinName;
    }

    public function getFatherName(): string {
        return $this->fatherName;
    }

    public function getMotherName(): string {
        return $this->motherName;
    }

    public function getDateOfBirth(): DateTime {
        return $this->dateOfBirth;
    }

    public function getPlaceOfBirth(): string {
        return $this->placeOfBirth;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getProfile(): string {
        return $this->profile;
    }

    public function getMajor(): string {
        return $this->major;
    }
}
?>