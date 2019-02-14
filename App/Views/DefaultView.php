<div class="promo">
    <img src="/assets/images/1.png">
    <div class="promo-content">
        <h4>
            Технічна інвентаризація потрібна при:
        </h4>
        <ul>
            <li>Зміна властника</li>
            <li>Зміна технічного стану</li>
            <li>Реконструкція, перепланування</li>
            <li>Розділ або обєднання майна</li>
            <li>Прийняття в есплуатацію</li>
        </ul>
    </div>
</div>

<div class="articles-list">
    <div class="articles-item">
        <h5 class="articles-item__title">
            Оформлення права власності
        </h5>
        <ul>
            <?php
            foreach ($articles1 as $item) {
                echo '<li>' . $item['title'] . '</li>';
            }
            ?>
        </ul>
    </div>
    <div class="articles-item">
        <h5 class="articles-item__title">
            Оформлення будівництва
        </h5>
        <ul>
            <?php
            foreach ($articles1 as $item) {
                echo '<li>' . $item['title'] . '</li>';
            }
            ?>
        </ul>
    </div>
    <div class="articles-item">
        <h5 class="articles-item__title">
            Операції з землею
        </h5>
        <ul>
            <?php
            foreach ($articles2 as $item) {
                echo '<li><a href="article/' . $item['id'] . '">' . $item['title'] . '</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="articles-item">
        <h5 class="articles-item__title">
            Перепланування та введеня в експлуатацію
        </h5>
        <ul>
            <?php
            foreach ($articles1 as $item) {
                echo '<li>' . $item['title'] . '</li>';
            }
            ?>
        </ul>
    </div>
</div>