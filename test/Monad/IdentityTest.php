<?php

namespace test\Monad;

use Widmogrod\FantasyLand\Applicative;
use Widmogrod\FantasyLand\Functor;
use Widmogrod\Helpful\ApplicativeLaws;
use Widmogrod\Helpful\FunctorLaws;
use Widmogrod\Monad\Identity;
use Widmogrod\Helpful\MonadLaws;
use Widmogrod\Functional as f;

class IdentityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideData
     */
    public function test_if_identity_monad_obeys_the_laws($f, $g, $x)
    {
        MonadLaws::test(
            f\curryN(3, [$this, 'assertEquals']),
            f\curryN(1, Identity::of),
            $f,
            $g,
            $x
        );
    }

    public function provideData()
    {
        $addOne = function ($x) {
            return Identity::of($x + 1);
        };
        $addTwo = function ($x) {
            return Identity::of($x + 2);
        };

        return [
            'Identity' => [
                '$f' => $addOne,
                '$g' => $addTwo,
                '$x' => 10,
            ],
        ];
    }

    /**
     * @dataProvider provideApplicativeTestData
     */
    public function test_it_should_obey_applicative_laws(
        Applicative $u,
        Applicative $v,
        Applicative $w,
        callable $f,
        $x
    ) {
        ApplicativeLaws::test(
            f\curryN(3, [$this, 'assertEquals']),
            f\curryN(1, Identity::of),
            $u,
            $v,
            $w,
            $f,
            $x
        );
    }

    public function provideApplicativeTestData()
    {
        return [
            'default' => [
                '$u' => Identity::of(function () {
                    return 1;
                }),
                '$v' => Identity::of(function () {
                    return 5;
                }),
                '$w' => Identity::of(function () {
                    return 7;
                }),
                '$f' => function ($x) {
                    return $x + 400;
                },
                '$x' => 33
            ],
        ];
    }

    /**
     * @dataProvider provideFunctorTestData
     */
    public function test_it_should_obey_functor_laws(
        callable $f,
        callable $g,
        Functor $x
    ) {
        FunctorLaws::test(
            f\curryN(3, [$this, 'assertEquals']),
            $f,
            $g,
            $x
        );
    }

    public function provideFunctorTestData()
    {
        return [
            'Identity' => [
                '$f' => function ($x) {
                    return $x + 1;
                },
                '$g' => function ($x) {
                    return $x + 5;
                },
                '$x' => Identity::of(123),
            ],
        ];
    }
}
