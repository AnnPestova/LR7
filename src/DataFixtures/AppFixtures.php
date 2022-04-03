<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        # модератор
        $adminRole = new Role();
        $adminRole->setName('Модератор');
        $manager->persist($adminRole);

        # пользователь
        $ordinaryRole = new Role();
        $ordinaryRole->setName('Пользователь');
        $manager->persist($ordinaryRole);

        # пользователь
        $userAnna = new User();
        $password = $this->hasher->hashPassword($userAnna, '123456');
        $userAnna->setName('Пестова Анна')
            ->setRole($adminRole)
            ->setEmail('annamorozova157@mail.ru')
            ->setPhone('89202494416')
            ->setPassword($password)
            ->setLastDateVisit(new \DateTime('now'))
            ->setToken('123e4567-e89b-12d3-a456-426614174000');
        $manager->persist($userAnna);

        # пользователь
        $userZlata = new User();
        $password = $this->hasher->hashPassword($userZlata, '123456');
        $userZlata->setName('Миронова Злата')
            ->setRole($adminRole)
            ->setEmail('zlata180401@mail.ru')
            ->setPhone('89202494416')
            ->setPassword($password)
            ->setLastDateVisit(new \DateTime('now'))
            ->setToken('123e4567-e89b-12d3-a456-426614174111');
        $manager->persist($userZlata);

        // категория вопроса
        $category = new Category();
        $category->setName('Философские вопросы');
        $manager->persist($category);

        $question1 = new Question();
        $question1->setUser($userAnna)
            ->setCategory($category)
            ->setTitle('Будучи ребенком в 21 веке - было ли раньше лучше?')
            ->setText('“Раньше все было лучше”. Может быть, вы уже слышали эту фразу от своих родителей, бабушек или дедушек. Наши родители выросли без Интернета и смартфонов. Для нас это почти невозможно, правда? Если вы из поколения Z, вы вероятно, выросли с такими вещами, как Интернет, телевизор и сотовые телефоны. Некоторые исследователи считают, что ранний контакт с электронными носителями (например, смартфонами, планшетами, игровыми консолями) вреден для развития ребенка. Социальная интеграция, контакты со сверстниками и уверенность детей в себе могут пострадать. Что вы думаете по этому поводу?')
            ->setDateAdded(new \DateTime('now'))
            ->setStatus(true);
        $manager->persist($question1);

        $question2 = new Question();
        $question2->setUser($userAnna)
            ->setCategory($category)
            ->setTitle('Гены или окружающая среда - откуда взялась наша личность?')
            ->setText('Являются ли интеллект и личностные качества врожденными, или же они развиваются под влиянием окружающей среды в подростковом возрасте? Ученые согласны с тем, что это комбинация того и другого. Но какой фактор, по вашему мнению, имеет более значительное влияние на развитие нашей личности?')
            ->setDateAdded(new \DateTime('now'))
            ->setStatus(true);
        $manager->persist($question2);

        $question3 = new Question();
        $question3->setUser($userAnna)
            ->setCategory($category)
            ->setTitle('Пока смерть не разлучит нас - существует ли вечная любовь?')
            ->setText('В наши дни свадеб становится все меньше, а разводов все больше. Быть счастливым с кем-то всю оставшуюся жизнь - это принятие желаемого за действительное или реальность?')
            ->setDateAdded(new \DateTime('now'))
            ->setStatus(true);
        $manager->persist($question3);

        $question4 = new Question();
        $question4->setUser($userZlata)
            ->setCategory($category)
            ->setTitle('Делают ли нас социальные сети больными?')
            ->setText('Facebook, Instagram, TikTok, Twitter. Мы все знаем положительные моменты в социальных сетях. Это весело, ведь вы связаны с людьми по всему миру, и у вас даже есть шанс сделать карьеру. Но каковы их недостатки? Могут ли социальные сети стать обузой?')
            ->setDateAdded(new \DateTime('now'))
            ->setStatus(true);
        $manager->persist($question4);

        $question5 = new Question();
        $question5->setUser($userZlata)
            ->setCategory($category)
            ->setTitle('Допустима ли эвтаназия с моральной точки зрения?')
            ->setText('В Европе только четыре страны, где разрешена эвтаназия: Бельгия, Люксембург, Швейцария и Нидерланды. В остальной Европе «убийство по требованию» является уголовным преступлением. Мнения по поводу моральной оправданности эвтаназии разделились.')
            ->setDateAdded(new \DateTime('now'))
            ->setStatus(true);
        $manager->persist($question5);

        $question6 = new Question();
        $question6->setUser($userZlata)
            ->setCategory($category)
            ->setTitle('Какая самая большая проблема человечества?')
            ->setText('Вы можете ответить на этот вопрос двумя разными способами. Либо вы сосредотачиваетесь на условиях окружающей среды (например, изменении климата), которые являются проблематичными для человечества, либо вы сосредотачиваетесь на личностных качествах людей (например, ненависть, зависть).')
            ->setDateAdded(new \DateTime('now'))
            ->setStatus(true);
        $manager->persist($question6);

        // ответ
        $answer1 = new Answer();
        $answer1->setUser($userAnna)
            ->setQuestion($question1)
            ->setText('Тестовый ответ 1.')
            ->setDateAdded(new \DateTime('now'))
            ->setRightness(0)
            ->setStatus(true);
        $manager->persist($answer1);

        // ответ
        $answer1_1 = new Answer();
        $answer1_1->setUser($userAnna)
            ->setQuestion($question1)
            ->setText('Тестовый ответ на ответ 1.')
            ->setDateAdded(new \DateTime('now'))
            ->setRightness(0)
            ->setStatus(true)
            ->setAnswer($answer1);
        $manager->persist($answer1_1);

        $answer2 = new Answer();
        $answer2->setUser($userAnna)
            ->setQuestion($question2)
            ->setText('Тестовый ответ 2.')
            ->setDateAdded(new \DateTime('now'))
            ->setRightness(0)
            ->setStatus(true);
        $manager->persist($answer2);

        $answer3 = new Answer();
        $answer3->setUser($userAnna)
            ->setQuestion($question3)
            ->setText('Тестовый ответ 3.')
            ->setDateAdded(new \DateTime('now'))
            ->setRightness(0)
            ->setStatus(true);
        $manager->persist($answer3);

        $answer4 = new Answer();
        $answer4->setUser($userZlata)
            ->setQuestion($question4)
            ->setText('Тестовый ответ 4.')
            ->setDateAdded(new \DateTime('now'))
            ->setRightness(0)
            ->setStatus(true);
        $manager->persist($answer4);

        $answer5 = new Answer();
        $answer5->setUser($userZlata)
            ->setQuestion($question5)
            ->setText('Тестовый ответ 5.')
            ->setDateAdded(new \DateTime('now'))
            ->setRightness(0)
            ->setStatus(true);
        $manager->persist($answer5);

        $answer6 = new Answer();
        $answer6->setUser($userZlata)
            ->setQuestion($question6)
            ->setText('Тестовый ответ 6.')
            ->setDateAdded(new \DateTime('now'))
            ->setRightness(0)
            ->setStatus(true);
        $manager->persist($answer6);


        $manager->flush();
    }
}
