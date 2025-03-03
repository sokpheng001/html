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
    private ?string $originalEmail; // Nullable
    private string $schoolEmail;
    private string $phoneNumber;
    private string $password;
    private string $profile;
    private string $major; // New field

    // Constructor
    // public function __construct(
    //     int $id, string $uuid, string $khmerName, string $latinName,
    //     string $fatherName, string $motherName, DateTime $dateOfBirth, string $placeOfBirth,
    //     ?string $email, string $phoneNumber, string $password, string $profile, string $major
    // ) {
    //     $this->id = $id;
    //     $this->uuid = $uuid;
    //     $this->khmerName = $khmerName;
    //     $this->latinName = $latinName;
    //     $this->fatherName = $fatherName;
    //     $this->motherName = $motherName;
    //     $this->dateOfBirth = $dateOfBirth;
    //     $this->placeOfBirth = $placeOfBirth;
    //     $this->email = $email;
    //     $this->phoneNumber = $phoneNumber;
    //     $this->password = $password;
    //     $this->profile = $profile;
    //     $this->major = $major;
    // }
// Setters
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setUuid(string $uuid): void {
        $this->uuid = $uuid;
    }

    public function setKhmerName(string $khmerName): void {
        $this->khmerName = $khmerName;
    }

    public function setLatinName(string $latinName): void {
        $this->latinName = $latinName;
    }

    public function setFatherName(string $fatherName): void {
        $this->fatherName = $fatherName;
    }

    public function setMotherName(string $motherName): void {
        $this->motherName = $motherName;
    }

    public function setDateOfBirth(DateTime $dateOfBirth): void {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function setPlaceOfBirth(string $placeOfBirth): void {
        $this->placeOfBirth = $placeOfBirth;
    }

    public function setEmail(?string $email): void {
        $this->originalEmail = $email;
    }
    public function setSchoolEmail(string $sEmail):void{
        $this->schoolEmail = $sEmail;
    }

    public function setPhoneNumber(string $phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setProfile(string $profile): void {
        $this->profile = $profile;
    }

    public function setMajor(string $major): void {
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

    public function getOriginalEmail(): ?string {
        return $this->originalEmail;
    }
    public function getSchoolEmail():string{
        return $this->schoolEmail;
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