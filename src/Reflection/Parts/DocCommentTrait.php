<?php

namespace Benoth\StaticReflection\Reflection\Parts;

trait DocCommentTrait
{
    /**
     * @type string Doc comments
     */
    protected $docComment;

    /**
     * Gets doc comments.
     *
     * @return string
     */
    public function getDocComment()
    {
        return $this->docComment;
    }

    /**
     * Sets doc comments.
     *
     * @param string $docComment
     *
     * @return self
     */
    public function setDocComment($docComment)
    {
        $this->docComment = $docComment;

        return $this;
    }
}
