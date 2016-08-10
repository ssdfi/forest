<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchemaMigrations
 *
 * @ORM\Table(name="schema_migrations", uniqueConstraints={@ORM\UniqueConstraint(name="unique_schema_migrations", columns={"version"})})
 * @ORM\Entity
 */
class SchemaMigrations
{
    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="schema_migrations_version_seq", allocationSize=1, initialValue=1)
     */
    private $version;



    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
}
