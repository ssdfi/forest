<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Titulares;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PlantacionesToNumberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Plantaciones|null $issue
     * @return string
     */
    public function transform($issue)
    {
        if (null === $issue) {
            return null;
        }

        return $issue->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $issueNumber
     * @return Plantaciones|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($issueNumber)
    {
        if (!$issueNumber) {
            return;
        }

        $issue = $this->manager
            ->getRepository('AppBundle:Plantaciones')
            ->findById($issueNumber)
        ;
        if (empty($issue)) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $issueNumber
            ));
        }
        return $issue[0];
    }
}
