<?php 

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $articlesData = [
            'Actualités' => [
                [
                   'title' => "Rentrée Scolaire 2023 : Nouveautés et Changements",
                    'content' => "Cette année, la rentrée scolaire marque un tournant important pour notre établissement. De nouvelles infrastructures ont vu le jour pour offrir un cadre d'apprentissage encore plus moderne et fonctionnel. Parmi les principales innovations, nous comptons la rénovation complète du laboratoire de sciences, désormais équipé de matériel dernier cri, permettant à nos élèves de mener des expériences de qualité professionnelle. En parallèle, la salle informatique a été entièrement modernisée avec des ordinateurs ultra-performants, offrant ainsi une connexion rapide et un environnement propice aux travaux collaboratifs. L’aménagement des espaces de travail a également été pensé pour favoriser la concentration et le travail en équipe, grâce à des bureaux modulables et des espaces de détente adaptés aux besoins des étudiants.\n\nLes nouveautés ne s'arrêtent pas là ! Nous avons également élargi notre offre pédagogique avec l’introduction de cours optionnels dans des domaines passionnants tels que les arts plastiques, la programmation informatique, ainsi que des cours d’approfondissement dans les disciplines scientifiques. Ces options viennent compléter l'enseignement traditionnel et permettent aux élèves d'acquérir des compétences de plus en plus demandées sur le marché du travail. Ces changements ont été pensés pour préparer nos élèves aux défis de demain, tout en leur offrant une expérience scolaire plus enrichissante. Les élèves auront ainsi l’opportunité de découvrir de nouvelles passions et de s'orienter plus facilement vers des domaines professionnels en accord avec leurs talents et aspirations.\n\nEnfin, des améliorations ont été apportées à l’organisation générale de l’école, avec de nouveaux espaces de détente et de travail collaboratif, conçus pour favoriser le bien-être et l’épanouissement des élèves. Nous avons aussi mis en place des horaires plus flexibles pour les activités périscolaires, permettant aux étudiants de mieux concilier leurs études et leurs loisirs. Cette rentrée promet d’être riche en découvertes et en nouvelles opportunités !",
                    'image' => "https://i.postimg.cc/bwG2Bmdf/494x326-rentr-e-scolaire-college-lyc-e.jpg",
                    'createAt' => new \DateTimeImmutable('2024-02-01'),
                ],
                [
                    'title' => "L'École Remporte le Prix de l'Éducation Durable",
                    'content' => "Notre établissement a récemment été récompensé pour ses initiatives en faveur du développement durable et de l'éducation environnementale. Parmi les projets mis en avant, on retrouve le potager scolaire, les ateliers de recyclage, ainsi que la réduction des déchets plastiques grâce à une politique de sensibilisation active. Ces projets, qui sont devenus des incontournables de notre quotidien, visent à sensibiliser nos élèves aux enjeux environnementaux et à les inciter à adopter des comportements écoresponsables. L'école a également mis en place des actions pour la préservation de la biodiversité locale, comme la plantation de haies végétales et la gestion écologique des espaces verts.\n\nLe potager scolaire, par exemple, permet aux élèves de découvrir le processus de culture et de récolte, tout en apprenant les bases de l'agriculture durable. Chaque classe participe activement à l'entretien du jardin, favorisant ainsi le travail d'équipe et l'apprentissage pratique. Par ailleurs, les ateliers de recyclage permettent aux élèves de comprendre l'importance de la gestion des déchets et de la réduction de notre empreinte écologique, tout en créant des objets utiles à partir de matériaux recyclés. Ces initiatives ne sont pas seulement un apprentissage théorique mais un véritable projet communautaire qui implique toute l'école.\n\nCette distinction est une véritable reconnaissance de l’engagement de notre établissement en matière d’éducation durable. Nous continuons d'innover et d'inciter nos élèves à devenir des citoyens responsables et conscients des enjeux environnementaux de demain. Ce prix vient couronner plusieurs années d’efforts et témoigne de la volonté de notre école de s’inscrire dans une démarche de développement durable à long terme.",
                    'image' => "https://i.postimg.cc/vZqCQLrz/IMG-20210617-WA0003.jpg",
                    'createAt' => new \DateTimeImmutable('2024-03-15'),
                ],
                [
                    'title' => "Nouveau Partenariat avec une École Internationale",
                    'content' => "Nous avons le plaisir d'annoncer un partenariat avec une école internationale, permettant des échanges culturels et linguistiques pour nos élèves. Ce partenariat vise à ouvrir nos élèves sur le monde et à les immerger dans des pratiques pédagogiques innovantes. L'école partenaire, située à l'étranger, partagera avec nous ses méthodes d'enseignement uniques, notamment en matière de langues étrangères, de sciences sociales et d'éducation artistique. Ce programme a pour but de préparer nos étudiants à une carrière internationale et de leur offrir une ouverture sur différentes cultures et systèmes éducatifs.\n\nGrâce à ce partenariat, nos élèves auront la chance de participer à des programmes d'échange qui les amèneront à séjourner dans le pays partenaire. Ces échanges leur offriront une expérience enrichissante, tant sur le plan académique que culturel, leur permettant de découvrir une nouvelle approche de l’enseignement, mais aussi d'apprendre de nouvelles langues et de tisser des liens d'amitié avec leurs homologues étrangers. Ce programme d'échange sera également une occasion pour eux de participer à des projets communs, notamment des compétitions sportives et artistiques, renforçant ainsi leur esprit de camaraderie et de coopération.\n\nNous sommes impatients de voir ce partenariat se développer et d’offrir à nos élèves des perspectives d'apprentissage inédites et internationales. Ce projet représente un investissement dans l’avenir de nos étudiants, en leur offrant la possibilité de s’ouvrir au monde et de développer des compétences interculturelles et professionnelles.",
                    'image' => "https://i.postimg.cc/dtHLKpxS/partenariats-entreprise.jpg",
                    'createAt' => new \DateTimeImmutable('2024-02-05'),
                ],
                [
                    'title' => "Les Élèves Brillent au Concours de Mathématiques",
                    'content' => "Félicitations à nos élèves qui ont remporté plusieurs prix lors du concours régional de mathématiques. Leur travail acharné et leur passion pour les sciences ont été récompensés. Ce concours, qui rassemble des centaines d'élèves de toute la région, est l'occasion pour nos jeunes talents de se mesurer à leurs pairs et de prouver leurs compétences en résolution de problèmes complexes. Nos élèves se sont distingués non seulement par leur maîtrise des concepts mathématiques, mais également par leur capacité à travailler en équipe et à collaborer pour résoudre des défis. Leur esprit de compétition et leur capacité à persévérer ont été essentiels à leur réussite.\n\nCes résultats sont le fruit d'un travail collectif entre les élèves, les enseignants et les parents. Les élèves ont eu l'occasion de se préparer à travers des ateliers de révision et des séances de soutien scolaire, qui leur ont permis de renforcer leur confiance en eux et de perfectionner leur méthodologie. Ce concours est non seulement une belle performance individuelle, mais aussi un signe de la qualité de l’enseignement dispensé dans notre établissement. Cette victoire est une source de fierté pour notre école et une motivation pour les futurs concours. Nous espérons que cet exemple inspirera d'autres élèves à se dépasser et à développer une passion pour les sciences.",
                    'image' => "https://i.postimg.cc/tg7cMZVM/Mj-Ax-Mz-A5-OTA0-NWFj-ZWQ0-Mz-U3-MTFi-Y2-Vi-Mj-Ix-Y2-Rj-ZTM1-ZDgx-NDI.avif",
                    'createAt' => new \DateTimeImmutable('2024-03-20'),
                ]
            ],
            
            'Événements' => [
                [
                    'title' => "Fête de l'École : Venez Nombreux !",
                    'content' => "La fête annuelle de l'école est un événement incontournable pour les élèves, leurs familles et toute la communauté éducative. Cette année, nous vous invitons à venir nombreux pour célébrer la fin de l'année scolaire avec nous. Au programme, des activités ludiques, des spectacles, des stands de jeux, mais aussi des expositions des travaux réalisés par les élèves tout au long de l'année. La fête de l’école sera l’occasion de découvrir les talents de nos élèves dans divers domaines, notamment le théâtre, la musique, les arts plastiques et la danse.\n\nLes familles et amis des élèves seront invités à participer aux animations et à découvrir l’environnement scolaire dans une ambiance festive et conviviale. Cet événement sera aussi une belle occasion de renforcer les liens entre les membres de la communauté scolaire, en partageant des moments de joie et de convivialité. La fête se déroulera le 15 juin, et nous espérons vous voir nombreux pour cette journée exceptionnelle qui marque la fin de l’année scolaire en beauté.",
                    'image' => "https://i.postimg.cc/HnkDTpZJ/unnamed.jpg",
                    'createAt' => new \DateTimeImmutable('2024-03-01'),
                ],
                [
                    'title' => "Portes Ouvertes : Découvrez Notre Établissement",
                    'content' => "Vous êtes curieux de découvrir notre établissement et les valeurs qu'il promeut ? Ne manquez pas notre journée portes ouvertes qui se tiendra le 10 mars. Ce sera l'occasion idéale de rencontrer nos enseignants, de visiter les locaux et de découvrir les différentes activités et projets qui animent notre école. Vous pourrez également poser toutes vos questions et obtenir des informations détaillées sur les programmes pédagogiques, les options proposées et les projets à venir.\n\nNous avons à cœur de vous accueillir dans un cadre chaleureux et de vous présenter notre environnement scolaire. La journée portes ouvertes est aussi un moment privilégié pour échanger avec les élèves et comprendre leurs expériences et parcours au sein de l'établissement. Nous vous invitons à venir nombreux pour cette journée spéciale, qui vous permettra de mieux connaître notre établissement et de faire un choix éclairé pour l’avenir de vos enfants.",
                    'image' => "https://i.postimg.cc/kGQcY8FK/JPO-620x312-article-620-312.jpg",
                    'createAt' => new \DateTimeImmutable('2024-02-01'),
                ],
                [
                    'title' => "Conférence sur l'Orientation Scolaire",
                    'content' => "L'orientation scolaire est un sujet central pour de nombreux élèves et leurs parents. C’est pourquoi nous organisons une conférence spéciale sur ce thème le 20 avril. Au cours de cette rencontre, des experts en orientation scolaire partageront leurs conseils et leurs expériences pour aider les élèves à prendre les bonnes décisions quant à leur avenir académique et professionnel. Les thèmes abordés incluront les différentes filières disponibles, les critères de choix en fonction des aptitudes et des aspirations personnelles, ainsi que les perspectives professionnelles dans chaque domaine.\n\nLa conférence sera ouverte à tous les élèves et leurs parents, et nous espérons qu’elle permettra de mieux préparer les futurs choix d’orientation des élèves en les accompagnant dans leurs réflexions. Nous souhaitons que chacun puisse repartir avec des informations précieuses et une meilleure vision des possibilités qui s'offrent à lui.",
                    'image' => "https://i.postimg.cc/Dzh7tKTG/bb7ae7593487637c8964cab035a803-d91cf.jpg",
                    'createAt' => new \DateTimeImmutable('2024-02-10'),
                ],
                [
                    'title' => "Sortie Scolaire au Musée des Sciences",
                    'content' => "Les élèves de 6ème auront l’opportunité de participer à une sortie scolaire au Musée des Sciences le 5 mai. Cette sortie a pour but de sensibiliser les élèves aux différentes découvertes scientifiques et à l'histoire de la science, tout en leur permettant de vivre une expérience pratique et interactive. Au programme, des ateliers, des visites guidées et des expositions pour illustrer de manière ludique les concepts étudiés en classe.\n\nCette sortie est également une occasion pour les élèves de renforcer leur esprit d'équipe et de découvrir de manière ludique l'importance de la science dans notre quotidien. Le musée propose des expositions dynamiques et pédagogiques qui captiveront l’attention des élèves, tout en enrichissant leur culture scientifique et leur curiosité. Nous sommes impatients de voir nos élèves s’épanouir lors de cette sortie et de renforcer leur passion pour les sciences.",
                    'image' => "https://i.postimg.cc/nzHBV5vj/field-media-image-183-0001133-001-0.jpg",
                    'createAt' => new \DateTimeImmutable('2024-02-15'),
                ]
            ],
            'Conseils Éducatifs' => [
                [
                    'title' => "Comment Aider Votre Enfant à Réussir en Mathématiques",
                    'content' => "Les mathématiques peuvent parfois sembler intimidantes pour certains élèves, mais il existe plusieurs méthodes efficaces pour aider votre enfant à surmonter les difficultés et réussir dans cette matière. Tout d’abord, il est important d’instaurer une routine d’étude régulière, en consacrant des moments précis à la révision des notions abordées en classe. L’utilisation d’exemples concrets, de jeux mathématiques et de ressources pédagogiques variées peut également rendre l'apprentissage plus accessible et amusant.\n\nEn outre, encouragez votre enfant à poser des questions en classe et à participer activement aux séances de révision. Si nécessaire, vous pouvez également lui proposer des séances de tutorat ou de soutien scolaire pour l’aider à comprendre les notions les plus complexes. Enfin, il est crucial de créer un environnement calme et propice à l'étude à la maison. Le soutien et l'encouragement sont des éléments clés pour qu’il gagne en confiance et progresse avec succès en mathématiques.",
                    'image' => "https://i.postimg.cc/zvprZLqH/Fq-I3-Mxph-Out-JTOsv6q-FX.png",
                    'createAt' => new \DateTimeImmutable('2024-02-15'),
                ],
                [
                    'title' => "L'Importance de la Lecture au Quotidien",
                    'content' => "La lecture est essentielle pour le développement intellectuel et émotionnel des enfants. Elle permet non seulement de développer un vocabulaire riche et une bonne compréhension de texte, mais elle contribue aussi à l'éveil de la créativité et à l’enrichissement culturel. Il est donc primordial d'inciter les enfants à lire régulièrement, à la fois pour le plaisir et pour acquérir de nouvelles connaissances.\n\nLire chaque jour, même pour quelques minutes, permet à l’enfant de développer sa concentration, sa compréhension du monde qui l'entoure et sa capacité à réfléchir de manière critique. Encouragez-le à explorer différents genres littéraires, des romans aux documentaires, et à partager ses impressions avec vous. Ainsi, la lecture deviendra un moment de plaisir et un outil précieux pour son développement personnel.",
                    'image' => "https://i.postimg.cc/MK2YQsbT/5-conseils-1024x1024.png",
                    'createAt' => new \DateTimeImmutable('2024-02-20'),
                ],
                [
                    'title' => "Techniques pour Apprendre Plus Rapidement",
                    'content' => "L'apprentissage rapide repose sur des techniques éprouvées comme la répétition espacée, la prise de notes efficace et l’utilisation de supports visuels. Une des méthodes les plus utilisées est la technique de la répétition espacée, qui consiste à revoir régulièrement les informations apprises pour les ancrer durablement dans la mémoire à long terme. En parallèle, une prise de notes claire et structurée peut aider l’élève à mieux organiser ses idées et à comprendre plus facilement les concepts.\n\nIl est également conseillé d’utiliser des supports visuels, comme des diagrammes ou des cartes mentales, pour faciliter la mémorisation. Enfin, la gestion du temps est essentielle pour maximiser l’apprentissage. L’élève doit être capable de diviser son travail en petites sessions et de se concentrer pleinement sur une tâche à la fois. Adopter ces techniques permettra à l’élève de mieux assimiler les informations et de gagner en efficacité.",
                    'image' => "https://i.postimg.cc/sD1RM4yv/maxresdefault.jpg",
                    'createAt' => new \DateTimeImmutable('2024-02-25'),
                ],
                [
                    'title' => "Gérer le Stress Avant les Examens",
                    'content' => "Les examens peuvent être source de stress pour de nombreux élèves, mais il existe des stratégies pour les aider à gérer ce stress et aborder leurs épreuves avec sérénité. Tout d'abord, il est essentiel de bien se préparer en répartissant les révisions sur plusieurs semaines, afin d’éviter la surcharge de travail de dernière minute. La relaxation est aussi une technique efficace pour gérer l’anxiété avant un examen. Des exercices de respiration ou de méditation peuvent aider l’élève à se détendre et à clarifier son esprit.\n\nIl est également important d’avoir une alimentation équilibrée et de pratiquer une activité physique régulière, car cela permet de maintenir un bon niveau d’énergie et de concentration. Enfin, veillez à ce que l’élève ait un bon sommeil la veille des examens pour qu’il puisse aborder l’épreuve en pleine forme. Ces conseils simples et pratiques permettront aux élèves de mieux gérer leur stress et d’aborder leurs examens en toute confiance.",
                    'image' => "https://i.postimg.cc/V6jkHB5Y/1444x920-pour-ne-pas-etre-depasse-par-le-stress-d-un-examen-rien-ne-vaut-une-bonne-preparation-preal.jpg",
                    'createAt' => new \DateTimeImmutable('2024-03-01'),
                ]
                ],
                'Vie Scolaire' => [
    [
        'title' => "Les Clubs de l'École : Quelle Activité Choisir ?",
        'content' => "Notre école propose une multitude de clubs et d’activités extrascolaires pour enrichir la vie des élèves et favoriser leur épanouissement personnel. Que ce soit dans les domaines sportifs, artistiques, scientifiques ou humanitaires, chaque élève peut trouver une activité qui correspond à ses centres d’intérêt et ses passions. Ces clubs sont également une excellente occasion pour les élèves de développer de nouvelles compétences, de faire de nouvelles rencontres et de s’engager dans des projets communautaires.\n\nParmi les clubs les plus populaires, on retrouve le club de théâtre, où les élèves peuvent exprimer leur créativité en préparant des pièces de théâtre et des performances, ou encore le club de robotique, qui permet aux passionnés de technologie de concevoir des robots et de participer à des compétitions régionales et nationales. Il existe également des clubs plus orientés vers l’engagement social, comme le club humanitaire qui organise des collectes et des événements pour soutenir diverses causes.\n\nChoisir un club, c’est également une belle occasion d'apprendre à gérer son emploi du temps, à travailler en équipe et à développer des compétences en leadership. Encouragez votre enfant à explorer différentes options afin de trouver l’activité qui lui permettra de s’épanouir en dehors des salles de classe.",
        'image' => "https://i.postimg.cc/htWgN7Wv/Extraescolares-baloncesto.png",
        'createAt' => new \DateTimeImmutable('2024-03-05'),
    ],
    [
        'title' => "Les Meilleurs Endroits pour Étudier",
        'content' => "Trouver un endroit calme et confortable pour étudier est essentiel pour maximiser sa concentration et sa productivité. Que ce soit à la maison, à l’école ou dans un café, un bon environnement d’étude favorise l’apprentissage et permet de mieux se concentrer. À l'école, nous avons aménagé des espaces dédiés à l’étude, comme des salles de travail en groupe et des coins lecture, où les élèves peuvent réviser, échanger et collaborer sur leurs projets.\n\nÀ la maison, il est important de choisir un endroit bien éclairé, sans distractions, et équipé de tout le matériel nécessaire (livres, ordinateurs, cahiers). Certains élèves préfèrent étudier dans des endroits plus calmes, comme une bibliothèque, où l’atmosphère tranquille et studieuse les aide à rester concentrés. Il est aussi conseillé d’organiser son espace de travail de manière fonctionnelle, en gardant uniquement l’essentiel pour éviter la surcharge visuelle.\n\nEnfin, les cafés et autres lieux publics peuvent être des endroits agréables pour étudier si l’on est capable de se concentrer malgré les distractions environnantes. L’essentiel est de trouver un endroit où l’on se sent à l’aise et productif, en fonction de ses préférences personnelles.",
        'image' => "https://i.postimg.cc/8zpFx3Vj/ecole-coronavirus-etudier-scolaire-maison.jpg",
        'createAt' => new \DateTimeImmutable('2024-03-10'),
    ],
    [
        'title' => "Comment Bien Organiser Son Emploi du Temps",
        'content' => "Une bonne gestion du temps est cruciale pour réussir à équilibrer études et loisirs. Savoir organiser son emploi du temps permet de mieux répartir les tâches, de réduire le stress et d’augmenter la productivité. L’une des premières étapes consiste à établir une liste des priorités en fonction des devoirs, des révisions, des projets et des activités extrascolaires. Cela permet de ne pas se laisser submerger par les différentes exigences.\n\nIl est aussi important de se fixer des objectifs réalistes et de les répartir sur la semaine en tenant compte de ses moments de pause. Des outils comme des agendas, des applications de gestion du temps ou des tableaux de planification peuvent être très utiles pour visualiser les tâches à accomplir et leur délai. Le temps de travail doit être équilibré avec des pauses régulières pour éviter la fatigue mentale et optimiser la concentration. N'oubliez pas de réserver aussi du temps pour les loisirs et les activités sociales, car elles sont essentielles pour maintenir un équilibre de vie sain.\n\nEn suivant ces conseils d’organisation, les élèves peuvent éviter les périodes de surmenage et rester motivés tout au long de l’année scolaire.",
        'image' => "https://i.postimg.cc/d3XYnhv2/emploi-du-temps-en-ligne.jpg",
        'createAt' => new \DateTimeImmutable('2024-03-15'),
    ],
    [
        'title' => "L'Importance du Sport dans le temps extrascolaire",
        'content' => "Le sport joue un rôle clé dans l’équilibre et le bien-être des étudiants. Il permet non seulement de maintenir une bonne forme physique, mais aussi de développer des qualités telles que la discipline, le travail d’équipe et la gestion du stress. À l’école, nous encourageons tous nos élèves à participer à des activités sportives, que ce soit en compétition ou en loisir. Le sport est un excellent moyen de décompresser après une journée d’étude intense et de se recentrer.\n\nLes bienfaits du sport sont multiples : amélioration de la santé cardiovasculaire, renforcement des muscles et des os, mais aussi une meilleure concentration en classe. Pratiquer régulièrement une activité physique contribue également à la gestion des émotions et permet de maintenir une bonne hygiène de vie, en réduisant les risques de stress et d’anxiété. Qu’il s’agisse de sport individuel comme la course ou la natation, ou de sports collectifs comme le football ou le basket, chaque élève peut trouver une activité qui lui correspond.\n\nLe sport est également un excellent moyen de renforcer la cohésion au sein des équipes et de créer des liens forts avec les autres élèves. En pratiquant ensemble, les élèves apprennent à collaborer, à se soutenir et à développer un esprit de camaraderie. Nous encourageons donc vivement la participation à des compétitions sportives et à des clubs sportifs au sein de l’école.",
        'image' => "https://i.postimg.cc/BZ1P9HPf/five-happy-teenage-kids-running-on-the-stadium-picture-id583849568.jpg",
        'createAt' => new \DateTimeImmutable('2024-03-20'),
    ]
]

        ];

        foreach ($articlesData as $categoryName => $articles) {
            foreach ($articles as $articleData) {
                $article = new Article();
                $article->setTitle($articleData['title'])
                    ->setContent($articleData['content'])
                    ->setImage($articleData['image'])
                    ->setCreateAt($articleData['createAt'])
                    ->setCategory($categoryName);

                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}
