<?php
/**
 * Shopware 4.0
 * Copyright © 2012 shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 *
 * @category   Shopware
 * @package    Shopware_Models
 * @subpackage Article
 * @copyright  Copyright (c) 2012, shopware AG (http://www.shopware.de)
 * @version    $Id$
 * @author     Patrick Stahl
 * @author     $Author$
 */

namespace   Shopware\Models\Article;
use Shopware\Components\Model\ModelEntity,
    Doctrine\ORM\Mapping AS ORM,
    Symfony\Component\Validator\Constraints as Assert,
    Doctrine\Common\Collections\ArrayCollection;
/**
 * Shopware Vote Model
 *
 * This is the model for s_articles_vote.
 * The model contains a single row of s_articles_vote, which is a vote of an article.
 * It has a n:1 association to Shopware\Models\Article\Article to get the name of the assigned article.
 *
 * @ORM\Entity
 * @ORM\Table(name="s_articles_vote")
 * @ORM\HasLifecycleCallbacks
 */
class Vote extends ModelEntity
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer $articleId
     *
     * @ORM\Column(name="articleID", type="integer", nullable=false)
     */
    private $articleId;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string $headline
     *
     * @ORM\Column(name="headline", type="string", length=255, nullable=false)
     */
    private $headline;

    /**
     * @var string $comment
     *
     * @ORM\Column(name="comment", type="text", nullable=false)
     */
    private $comment;

    /**
     * @var float $points
     *
     * @ORM\Column(name="points", type="float", nullable=false)
     */
    private $points;

    /**
     * @var datetime $datum
     *
     * @ORM\Column(name="datum", type="datetime", nullable=false)
     */
    private $datum;

    /**
     * @var integer $active
     *
     * @ORM\Column(name="active", type="integer", nullable=false)
     */
    private $active;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string $answer
     *
     * @ORM\Column(name="answer", type="text", nullable=false)
     */
    private $answer;

    /**
     * @var datetime $answer_date
     *
     * @ORM\Column(name="answer_date", type="datetime", nullable=false)
     */
    private $answer_date;

    /**
     * OWNING SIDE
     * @var \Shopware\Models\Article\Article $article
     * @ORM\ManyToOne(targetEntity="Shopware\Models\Article\Article", inversedBy="votes", cascade={"persist", "update"})
     * @ORM\JoinColumn(name="articleID", referencedColumnName="id")
     */
    protected $article;

    /**
     * Gets the primaryKey id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the name of the write of the vote
     * Example: John
     *
     * @param string $name
     * @return Vote
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets the name of the writer of the vote
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the headline from the vote
     *
     * @param string $headline
     * @return Vote
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
        return $this;
    }

    /**
     * Gets the headline from the vote
     *
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Sets the comment - the vote itself
     *
     * @param string $comment
     * @return Vote
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Gets the vote itself
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Sets the given points for the vote
     *
     * @param float $points
     * @return Vote
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     * Gets the given points of the vote
     *
     * @return float
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Sets the datum of the vote
     *
     * @param datetime $datum
     * @return Vote
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
        return $this;
    }

    /**
     * Gets the datum of the vote
     *
     * @return datetime
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Sets the vote activation-status
     * 1 = accepted, 0 = not accepted yet
     *
     * @param integer $active
     * @return Vote
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Gets the activation-status of the vote
     * 1 = accepted, 0 = not accepted yet
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Sets the email of the writer
     *
     * @param string $email
     * @return Vote
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Gets the email of the writer
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the answer of the shop-owner to a vote
     *
     * @param string $answer
     * @return Vote
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
        return $this;
    }

    /**
     * Gets the answer of a premium-article
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Sets the datum of the answer
     *
     * @param datetime $answer_date
     * @return Vote
     */
    public function setAnswerDate($answer_date)
    {
        if (!$answer_date instanceof \DateTime) {
            $answer_date = new \DateTime($answer_date);
        }
        $this->answer_date = $answer_date;
        return $this;
    }

    /**
     * Gets the datum of the answer
     *
     * @return datetime
     */
    public function getAnswerDate()
    {
        return $this->answer_date;
    }

    /**
     * OWNING SIDE
     * of the association between votes and article
     * @return \Shopware\Models\Article\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param \Shopware\Models\Article\Article|array|null $article
     * @return \Shopware\Models\Article\Vote
     */
    public function setArticle($article)
    {
        $this->article = $article;
        return $this;
    }
}
