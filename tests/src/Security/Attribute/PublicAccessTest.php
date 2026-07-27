<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Security\Attribute;

use Error;
use ReflectionClass;
use ReflectionMethod;
use Waffle\Commons\Contracts\Security\Attribute\PublicAccess;
use WaffleTests\Commons\Contracts\AbstractTestCase;

final class PublicAccessTest extends AbstractTestCase
{
    public function testIsInstantiableOnAMethod(): void
    {
        $fixture = new class {
            #[PublicAccess]
            public function action(): void {}
        };

        $attributes = new ReflectionMethod($fixture, 'action')->getAttributes(PublicAccess::class);
        $attribute = $attributes[0] ?? null;

        static::assertNotNull($attribute);
        static::assertInstanceOf(PublicAccess::class, $attribute->newInstance());
    }

    public function testRejectsClassLevelPlacement(): void
    {
        // SEC-05 (Beta6 audit): a prior revision also allowed class-level
        // placement, silently exempting every unvoted method a controller
        // ever gained. `Attribute::TARGET_METHOD` alone doesn't reject a
        // stray class-level `#[PublicAccess]` at declare time — PHP only
        // validates an attribute's target when `newInstance()` is called on
        // the reflected attribute.
        //
        // mago's own static analyzer ALSO enforces this restriction (as an
        // analyzer error) — a literal `#[PublicAccess]` on a class declared
        // in this file's own source would never pass `composer mago`, and
        // `eval()` is separately banned outright (no-eval). The fixture is
        // instead written to a temp file OUTSIDE the analyzed source tree
        // and required — the same technique ContainerCompilerTest already
        // uses to load generated code — so this one deliberately-invalid
        // placement is invisible to static analysis, purely to prove the
        // runtime (`newInstance()`) behavior in isolation: defense in depth
        // behind the static gate, not a replacement for it.
        $source =
            "<?php\n\n"
            . "declare(strict_types=1);\n\n"
            . "namespace WaffleTests\\Commons\\Contracts\\Security\\Attribute\\Fixture;\n\n"
            . "#[\\Waffle\\Commons\\Contracts\\Security\\Attribute\\PublicAccess]\n"
            . "final class StrayClassLevelFixture {}\n";

        $file = sys_get_temp_dir() . '/wfl_public_access_fixture_' . uniqid() . '.php';
        file_put_contents($file, $source);

        try {
            require $file;
        } finally {
            unlink($file);
        }

        $reflection = new ReflectionClass(Fixture\StrayClassLevelFixture::class);
        $attributes = $reflection->getAttributes(PublicAccess::class);
        $attribute = $attributes[0] ?? null;

        static::assertNotNull(
            $attribute,
            'The attribute must still compile onto a class — PHP does not validate targets at declare time.',
        );

        $this->expectException(Error::class);
        $this->expectExceptionMessageMatches('/cannot target class/');

        $attribute->newInstance();
    }
}
