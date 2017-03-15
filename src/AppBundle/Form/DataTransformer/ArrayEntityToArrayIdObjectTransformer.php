<?php
namespace AppBundle\Form\DataTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ArrayEntityToArrayIdObjectTransformer implements DataTransformerInterface
{
    private $em;
    private $entityName;
    public function __construct(EntityManager $em, $entityName)
    {
        $this->em = $em;
        $this->entityName = $entityName;
    }
    public function transform($arrayObject)
    {
        if (null === $arrayObject) {
            return array();
        }
        $choices = array();
        foreach ($arrayObject as $object)
        {
           $choices[] = $object->getId();
        }
        return $choices;
    }
    public function reverseTransform($arrayIdObject)
    {
        if (!$arrayIdObject) {
            return array();
        }
        $arrayObject = array();
        foreach ($arrayIdObject as $idObject)
        {
            $object = $this->em
                ->getRepository($this->entityName)
                ->find($idObject)
            ;
            if (null === $object) {
                throw new TransformationFailedException(sprintf(
                    'O objeto de id "%s" não existe!',
                    $idObject
                ));
            } else {
                $arrayObject[] = $object;
            }
        }
        return $arrayObject;
    }
}
