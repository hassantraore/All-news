<?php


namespace App\Twig;


use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use App\Entity\Category;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository =$categoryRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('categorieNavbar',[$this,'categorie'])

        ];
    }

    public function categorie():array
    {
        return $this->categoryRepository->findAll();
    }


}