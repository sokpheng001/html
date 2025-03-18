<?php
    function schoolEmailGenerator(string $name): string{
            // Convert the string to lowercase
        $lowercaseString = strtolower($name);

    // Remove spaces from the string
        $noSpacesName = str_replace(' ', '', $lowercaseString);
        $randomFourDigits = rand(1000, 9999);
    // Get the current year
        $currentYear = date("Y");
        return  $noSpacesName.".".$currentYear.$randomFourDigits."@gmail.edu.kh";
    }
?>