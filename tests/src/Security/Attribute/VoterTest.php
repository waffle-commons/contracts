<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Security\Attribute;

use Waffle\Commons\Contracts\Security\Attribute\Voter;
use WaffleTests\Commons\Contracts\AbstractTestCase;

final class VoterTest extends AbstractTestCase
{
    public function testConstructorExposesVoterName(): void
    {
        $voter = new Voter(name: 'App\\Voter\\MyCustomVoter');

        static::assertSame('App\\Voter\\MyCustomVoter', $voter->name);
    }
}
