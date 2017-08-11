<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Especies;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;

class EspeciesToNumberTransformer implements DataTransformerInterface
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
        if (true === $issue->getEspecie()) {
            return null;
        }
        foreach ($issue as $key => $value) {
          return $value;
        }
        return $issue;
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
        // no issue number? It's optional, so that's ok
        if ($issueNumber->getEspecie()->isEmpty()) {
            return;
        }
        $especies = new ArrayCollection();
        foreach ($issueNumber->getEspecie() as $key => $value) {
          $issue = $this->manager
          ->getRepository('AppBundle:Especies')->findOneById($value);
          $especies->add($issue);
        }
        if (null === $issueNumber) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $issueNumber
            ));
        }
        return $especies;
    }
}
