<?php

declare(strict_types=1);

use App\Core\View;

$contact =
    is_array(
        $contact ?? null
    )
        ? $contact
        : [];


$eyebrow =
    (string) (
        $contact['eyebrow']
        ?? 'ارتباط با موسسه'
    );

$title =
    (string) (
        $contact['title']
        ?? 'تماس با ما'
    );

$description =
    (string) (
        $contact['description']
        ?? 'اطلاعات رسمی تماس موسسه آموزش عالی صدرالمتالهین.'
    );


$email =
    trim(
        (string) (
            $contact['email']
            ?? ''
        )
    );


$phone =
    trim(
        (string) (
            $contact['phone']
            ?? ''
        )
    );


$fax =
    trim(
        (string) (
            $contact['fax']
            ?? ''
        )
    );


$address =
    trim(
        (string) (
            $contact['address']
            ?? ''
        )
    );


$mapEyebrow =
    (string) (
        $contact['map_eyebrow']
        ?? 'موقعیت موسسه'
    );


$mapTitle =
    (string) (
        $contact['map_title']
        ?? 'تهران، ایران'
    );


$mapDescription =
    (string) (
        $contact['map_description']
        ?? ''
    );


$mapEmbed =
    trim(
        (string) (
            $contact['map_embed']
            ?? ''
        )
    );


$phoneHref =
    preg_replace(
        '/[^0-9+]/',
        '',
        $phone
    );


if (
    !is_string($phoneHref)
) {
    $phoneHref = '';
}

?>

<section class="institution-page">

    <div class="container">

        <div class="institution-hero">

            <span>
                <?= View::escape(
                    $eyebrow
                ) ?>
            </span>

            <h1>
                <?= View::escape(
                    $title
                ) ?>
            </h1>

            <p>
                <?= View::escape(
                    $description
                ) ?>
            </p>

        </div>


        <div class="contact-grid">


            <article class="institution-card">

                <span class="contact-card__icon">
                    ✉
                </span>

                <h2>
                    پست الکترونیکی
                </h2>

                <?php if (
                    $email !== ''
                ): ?>

                    <a
                        href="mailto:<?= View::escape(
                            $email
                        ) ?>"
                    >
                        <?= View::escape(
                            $email
                        ) ?>
                    </a>

                <?php endif; ?>

            </article>


            <article class="institution-card">

                <span class="contact-card__icon">
                    ☎
                </span>

                <h2>
                    تلفن
                </h2>

                <?php if (
                    $phone !== ''
                ): ?>

                    <a
                        href="tel:<?= View::escape(
                            $phoneHref
                        ) ?>"
                    >
                        <?= View::escape(
                            $phone
                        ) ?>
                    </a>

                <?php endif; ?>

            </article>


            <article class="institution-card">

                <span class="contact-card__icon">
                    ▣
                </span>

                <h2>
                    دورنگار
                </h2>

                <p>
                    <?= View::escape(
                        $fax
                    ) ?>
                </p>

            </article>


            <article class="institution-card">

                <span class="contact-card__icon">
                    📍
                </span>

                <h2>
                    نشانی
                </h2>

                <p>
                    <?= View::escape(
                        $address
                    ) ?>
                </p>

            </article>

        </div>


        <div class="contact-map">

            <div class="contact-map__content">

                <span>
                    <?= View::escape(
                        $mapEyebrow
                    ) ?>
                </span>

                <h2>
                    <?= View::escape(
                        $mapTitle
                    ) ?>
                </h2>

                <?php if (
                    $mapDescription !== ''
                ): ?>

                    <p>
                        <?= View::escape(
                            $mapDescription
                        ) ?>
                    </p>

                <?php endif; ?>

            </div>


            <?php if (
                $mapEmbed !== ''
            ): ?>

                <div class="contact-map__frame">

                    <iframe
                        src="<?= View::escape(
                            $mapEmbed
                        ) ?>"
                        title="موقعیت موسسه آموزش عالی صدرالمتالهین"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="strict-origin-when-cross-origin"
                    ></iframe>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>