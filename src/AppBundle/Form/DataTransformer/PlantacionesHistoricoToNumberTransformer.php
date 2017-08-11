<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\PlantacionesHistorico;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;

class PlantacionesHistoricoToNumberTransformer implements DataTransformerInterface
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
        $choices = array();
        foreach ($issue as $key => $value) {
          $choices[] = $value->getPlantacionNueva();
        }
        return $choices;
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
        $plantacioneshistorico = new ArrayCollection();
        foreach ($issue as $key => $value) {
          $historico = new PlantacionesHistorico($value,null);
          $historico->setPlantacionNueva($value);
          $historico->setPlantacionAnterior(null);
          $plantacioneshistorico->add($historico);
        }

        if (null === $issue) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $issueNumber
            ));
        }
        return $plantacioneshistorico;
    }
}
