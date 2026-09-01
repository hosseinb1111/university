<?php
declare(strict_types=1);

use App\Core\View;
$fullName = is_array($president)
    ? trim(
        $president['first_name']
        . ' '
        . $president['last_name']
    )
    : '';
?>

<section class="english-page">

    <div class="english-container">

        <div class="english-page__hero">

            <span>
                Presidency
            </span>

            <h1>
                Office of the President
            </h1>

            <p>
                Information about the leadership of Sadra Institute of Higher Education.
            </p>

        </div>


        <?php if (
            is_array($president)
        ): ?>

            <article class="english-president">

                <?php if (
                    !empty(
                        $president['image']
                    )
                ): ?>

                    <img
                        src="<?= View::escape(
                            $president['image']
                        ) ?>"
                        alt="<?= View::escape(
                            $fullName
                        ) ?>"
                    >

                <?php endif; ?>


                <div>

                    <span>
                        President
                    </span>

                    <h2>
                        <?= View::escape(
                            $fullName
                        ) ?>
                    </h2>


                    <?php if (
                        !empty(
                            $president['biography']
                        )
                    ): ?>

                        <p>
                            <?= nl2br(
                                View::escape(
                                    $president[
                                        'biography'
                                    ]
                                )
                            ) ?>
                        </p>

                    <?php endif; ?>


                    <?php if (
                        !empty(
                            $president['email']
                        )
                    ): ?>

                        <a
                            href="mailto:<?= View::escape(
                                $president['email']
                            ) ?>"
                        >
                            <?= View::escape(
                                $president['email']
                            ) ?>
                        </a>

                    <?php endif; ?>

                </div>

            </article>

        <?php else: ?>

            <div class="english-empty">
                Presidency information is not currently available.
            </div>

        <?php endif; ?>

    </div>

</section>
