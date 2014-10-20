<?php namespace DShoreman\Shop\Updates;

use Seeder;
use DShoreman\Shop\Models\Category;
use DShoreman\Shop\Models\Product;

class DemoSeed extends Seeder {

    public function run()
    {
        $this->createCategories([[
            'Books', 'books', 1,
            'Here be some books up fer grabs!'
        ],
        [
            'Games & Consoles', 'games-consoles', 2,
            'Bored? Twiddle yer thumbs on these new titles...'
        ]]);

        $this->createProducts([[
            1, 'Hogfather', 'hogfather', '9.99',
            "<p>IT'S THE NIGHT BEFORE HOGSWATCH. AND IT'S TOO QUIET.</p><p>Where is the big jolly fat man? Why is Death creeping down chimneys and trying to say Ho Ho Ho? The darkest night of the year is getting a lot darker...</p><p>Susan the gothic governess has got to sort it out by morning, otherwise there won't be a morning. Ever again...</p><p>The 20th Discworld novel is a festive feast of darkness and Death (but with jolly robins and tinsel too).</p><p>As they say: 'You'd better watch out...'</em></p>"
        ],
        [
            2, 'Battlefield 3', 'battlefield-3', '18.00',
            "<p>Battlefield 3 leaps ahead of its time with the power of Frostbite 2, the next instalment of DICE's game engine. This state-of-the-art technology is the foundation on which Battlefield 3 is built, delivering enhanced visual quality, a grand sense of scale, massive destruction, dynamic audio and incredibly lifelike character animations. As bullets whiz by, walls crumble, and explosions throw you to the ground, the battlefield feels more alive and interactive than ever before. In Battlefield 3, players step into the role of the elite U.S. Marines where they will experience heart-pounding missions across diverse locations including Paris, Tehran and New York.</p>"
        ],
        [
            2, 'Battlefield 4', 'battlefield-4', '38.95',
            "<p>The genre-defining action blockbuster returns as Battlefield 4 blazes onto Xbox One, PlayStation 4, Xbox 360, PlayStation 3 and PC!</p><p>Destroying the buildings that shield your enemies. Leading an assault from the back of a gunboat. Only in Battlefield can you do this and more.</p><p>Battlefield 4 ramps up the traditional Battlefield action to the next level thanks to the next-generation power and fidelity of the Frostbite 3 engine, with an intense single-player campaign that will push you to your limits as you and your squad struggle against the odds to return American VIPs home.</p><p>On top of this is the hallmark multiplayer that will continue to immerse you and your fellow players in the glorious chaos of all-out war, with a new addition - Battlepacks. Packed with a combination of new weapon accessories, dog tags, XP boosts, and more, Battlepacks are awarded during gampelay, adding a new elements of persistence and chance.</p><p>Carve your path to victory and order Battlefield 4 today!</p><ul><li>Xbox One Release Date 22/11/2013</li><li>PlayStation 4 Release Date 29/11/2013</li></ul>"
        ],
        [
            1, 'Anathem', 'anathem-neil-stephenson', '6.99',
            "<p>This is the latest magnificent creation from the award-winning author of \"Cryptonomicon and the Baroque Cycle\" trilogy. Erasmas, 'Raz', is a young avout living in the Concent, a sanctuary for mathematicians, scientists, and philosophers. Three times during history's darkest epochs, violence has invaded and devastated the cloistered community. Yet the avout have always managed to adapt in the wake of catastrophe. But they now prepare to open the Concent's gates to the outside world, in celebration of a once-a-decade rite. Suddenly, Erasmas finds himself a major player in a drama that will determine the future of his world - as he sets out on an extraordinary odyssey that will carry him to the most dangerous, inhospitable corners of the planet...and beyond.</p>"
        ],
        [
            1, 'Going Postal', 'going-postal-terry-pratchett', '8.99',
            "<p>Moist von Lipwig is a con artist...</p><p>... and a fraud and a man faced with a life choice: be hanged, or put Ankh-Morpork's ailing postal service back on its feet.</p><p>It's a tough decision.</p><p>But he's got to see that the mail gets through, come rain, hail, sleet, dogs, the Post Office Workers' Friendly and Benevolent Society, the evil chairman of the Grand Trunk Semaphore Company, and a midnight killer.</p><p>Getting a date with Adora Bell Dearheart would be nice, too...</p>"
        ]]);
    }

    public function createCategories($categories)
    {
        foreach ($categories as $category)
        {
            $c = new Category;
            $c->title = $category[0];
            $c->slug = $category[1];
            $c->sort_order = $category[2];
            $c->description = $category[3];
            $c->save();
        }
    }

    public function createProducts($products)
    {
        foreach ($products as $product)
        {
            $p = new Product;
            $p->category_id = $product[0];
            $p->title = $product[1];
            $p->slug = $product[2];
            $p->description = $product[4];
            $p->price = $product[3];
            $p->save();
        }
    }

}
