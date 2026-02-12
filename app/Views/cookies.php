<?php
$title = "Politique de cookies";
ob_start();
?>

<section class="page">
  <div class="page-inner policy-page">
    <h1>Politique de cookies</h1>
    <p class="policy-meta">LA PRÉSENTE POLITIQUE A ÉTÉ MISE À JOUR LE 03/02/2026.</p>
    <p>Lorsque vous visitez ou interagissez avec nos sites, nous ou nos prestataires de services autorisés pouvons utiliser des cookies, balises Web et autres technologies similaires pour stocker des informations qui nous permettront de vous fournir une meilleure expérience, plus rapide et plus sécurisée, ainsi qu'à des fins publicitaires.</p>
    <p>La présente page est conçue pour vous aider à mieux comprendre lesdites technologies et l'utilisation que nous en faisons sur nos sites. Vous trouverez ci-après une synthèse des quelques points clés à connaître à propos de notre utilisation desdites technologies.</p>

    <h2>Que sont les cookies, balises Web et technologies similaires ?</h2>
    <p>Comme la plupart des sites, nous utilisons des technologies qui sont des petits fichiers de données placés sur votre ordinateur, votre tablette, votre téléphone mobile ou tout autre appareil (ci-après collectivement désignés comme des « appareils ») qui nous permettent d'enregistrer un certain nombre d'informations lorsque vous visitez ou interagissez avec nos sites, services, applications, messageries et outils.</p>
    <p>Les types et noms spécifiques des cookies, balises et autres technologies similaires que nous utilisons peuvent varier à tout moment. Afin de mieux comprendre la présente Politique et notre utilisation desdites technologies, nous fournissons les définitions et la terminologie limitées suivantes :</p>

    <h3>Cookies</h3>
    <p>Petits fichiers texte (généralement composés de lettres et de chiffres) placés dans la mémoire de votre navigateur ou de votre appareil lorsque vous visitez un site Web ou affichez un message. Les cookies permettent à un site Web de reconnaître un appareil ou un navigateur spécifique.</p>
    <p>Il existe différents types de cookies :</p>
    <ul>
      <li><strong>Les cookies de session</strong> expirent à la fin de votre session de navigation et nous permettent d'associer vos actions au cours de cette session.</li>
      <li><strong>Les cookies persistants</strong> sont stockés sur votre appareil entre les sessions du navigateur, ce qui nous permet de conserver vos préférences ou actions sur plusieurs sites.</li>
      <li><strong>Les cookies internes</strong> sont définis par le site que vous visitez.</li>
      <li><strong>Les cookies tiers</strong> sont définis par un site tiers, différent du site que vous visitez.</li>
    </ul>
    <p>Les cookies peuvent être désactivés ou supprimés par des outils disponibles sur la plupart des navigateurs commerciaux. Les préférences de chaque navigateur que vous utilisez devront être définies séparément car chaque navigateur propose des fonctionnalités et options différentes.</p>

    <h3>Balises Web</h3>
    <p>Petites images graphiques (également connue sous le nom de « pixels espions » ou « GIF invisibles ») qui peuvent être ajoutées sur nos sites, services, applications, messageries et outils. Elles sont généralement utilisées avec des cookies pour identifier nos utilisateurs et leur comportement.</p>

    <h3>Autres technologies similaires</h3>
    <p>Technologies qui stockent des informations dans votre navigateur ou dans votre appareil à l'aide d'objets locaux partagés ou de stockage local, tels que des cookies ou témoins Flash ou HTML 5 et d'autres logiciels d'application Web. Ces technologies peuvent fonctionner sur l'ensemble de vos navigateurs. Dans certains cas, elles peuvent ne pas être entièrement gérées par les navigateurs et nécessiter une gestion directement par le biais de votre appareil ou de vos applications installées. Nous n'utilisons pas ces technologies pour stocker des informations en vue de cibler des publicités à votre intention sur ou en dehors de nos sites.</p>
    <p>Nous pourrons utiliser les termes « cookies » ou « technologies similaires » de manière interchangeable dans nos politiques pour nous référer à toutes les technologies que nous sommes susceptibles d'utiliser pour stocker des données dans votre navigateur ou appareil, collecter des informations ou nous aider à vous identifier de la manière susmentionnée.</p>

    <h2>Les cookies utilisés sur ce site Internet</h2>
    <p>Les cookies utilisés sur ce site Internet peuvent être regroupés en trois catégories décrites ci-dessous.</p>

    <h3>Cookies de performance</h3>
    <p>Ces cookies nous permettent de compter le nombre de visites et d'identifier les sources de traffic afin de mesurer et d'améliorer la performance de notre site. Ils nous aident à identifier les pages qui sont le plus populaires et celles qui le sont moins et nous permettent de voir comment les visiteurs naviguent sur le site. Toutes les informations collectées par ces cookies sont agrégées et donc anonymes. Si vous n'autorisez pas ces cookies, nous ne saurons pas quand vous avez visité notre site et nous ne pourrons pas contrôler sa performance.</p>
    <p>Dans le tableau ci-dessous vous trouverez une liste des cookies statistiques utilisés sur ce site internet.</p>

    <div class="policy-table">
      <table>
        <thead>
          <tr>
            <th>NOM DES COOKIES</th>
            <th>DURÉE</th>
            <th>INTERNES OU TIERS</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>_ga</td>
            <td>2 ans</td>
            <td>Les cookies tiers</td>
          </tr>
          <tr>
            <td>_gid</td>
            <td>24 heures</td>
            <td>Les cookies tiers</td>
          </tr>
          <tr>
            <td>_ga_&lt;container-id&gt;</td>
            <td>2 ans</td>
            <td>Les cookies tiers</td>
          </tr>
          <tr>
            <td>_gac_gb_&lt;container-id&gt;</td>
            <td>90 jours</td>
            <td>Les cookies tiers</td>
          </tr>
        </tbody>
      </table>
    </div>

    <h2>À propos de la présente politique</h2>
    <p>Nous pouvons modifier ponctuellement la politique sur les cookies, en tout ou en partie, à notre discrétion. La dernière version de ce document sera toujours disponible sur notre site Internet et prendra effet à la date de sa mise à jour.</p>
    <br><br>
    <p>Pour toutes questions, veuillez contacter <a href="/contact">Maison Eau D'or</a>.</p>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";
