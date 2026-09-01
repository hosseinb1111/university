<?php
declare(strict_types=1);

use App\Core\View;
use App\Models\Navigation;

$navigation =
    Navigation::tree();
?>

<nav
    class="public-navigation"
    aria-label="Ù…Ù†ÙˆÛŒ Ø§ØµÙ„ÛŒ"
>

    <div class="container">

        <ul class="public-navigation__list">

            <?php foreach (
                $navigation
                as $item
            ): ?>

                <?php
                $children =
                    $item['children']
                    ?? [];

                $hasChildren =
                    $children !== [];

                $url =
                    Navigation::url(
                        $item
                    );

                $target =
                    $item['target']
                    ?? '_self';
                ?>

                <li
                    class="
                        public-navigation__item
                        <?= $hasChildren
                            ? 'public-navigation__item--has-children'
                            : ''
                        ?>
                    "
                >

                    <a
                        href="<?= View::escape(
                            $url
                        ) ?>"
                        class="public-navigation__link"
                        <?php if (
                            $target === '_blank'
                        ): ?>
                            target="_blank"
                            rel="noopener noreferrer"
                        <?php endif; ?>
                    >
                        <?= View::escape(
                            $item['title']
                        ) ?>

                        <?php if (
                            $hasChildren
                        ): ?>

                            <span
                                class="public-navigation__arrow"
                            >
                                â–¾
                            </span>

                        <?php endif; ?>

                    </a>


                    <?php if (
                        $hasChildren
                    ): ?>

                        <div
                            class="public-navigation__dropdown"
                        >

                            <?php foreach (
                                $children
                                as $child
                            ): ?>

                                <a
                                    href="<?= View::escape(
                                        Navigation::url(
                                            $child
                                        )
                                    ) ?>"
                                    class="public-navigation__dropdown-link"
                                    <?php if (
                                        ($child['target']
                                        ?? '_self')
                                        === '_blank'
                                    ): ?>
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    <?php endif; ?>
                                >
                                    <?= View::escape(
                                        $child['title']
                                    ) ?>
                                </a>

                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>

                </li>

            <?php endforeach; ?>

        </ul>

    </div>

</nav>
