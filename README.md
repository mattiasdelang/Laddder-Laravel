# PHP 2 - Project

## Built using the PHP Laravel framework.

## Contributors:

- **Glenn Van Haute**: Scrum master
- **Bram De Nyn**: Developer
- **Mattias Delang**: Developer
- **Stijn D'Hollander**: Developer
- **Yannick Nijs**: Designer
- **Pieter Van Der Elst**: Designer

## Setup

Om het project up & running te krijgen, voer je volgende stappen uit:

**Lokaal**

1. Open een terminal met git functionaliteit en ga naar de map waarin je de projectmap wil aanmaken (bv. D:\Git). Zorg ervoor dat op je lokale machine je SSH keys goed geconfigureerd zijn. Als dit in orde is, sla je stap 2 over.
2. SSH keys instellen op je lokale machine: https://help.github.com/articles/generating-ssh-keys/
3. ```git clone git@bitbucket.org:bram_de_nyn/laddder.git <naam van de map>``` - Als je geen mapnaam meegeeft, wordt het in een map gezet met de naam van de repository, e.g. **laddder**. Hiermee wordt de remote repository lokaal overgenomen.
4. ```cd .\laddder``` - Ga in de net aangemaakte map.
5. ```vagrant up``` - Start de Virtual Machine op en zorgt er dus voor dat we lokaal kunnen ontwikkelen.
6. ```vagrant ssh``` - Connecteer met de Virtual Machine via ssh.

**Remote**

Vanaf dit punt zijn we remote op onze scotchbox met vagrant installatie aan het werken. Dit is een Linux-omgeving, m.a.w. Linux terminal commando's kunnen gebruikt worden.

7. ```cd .\var\www\``` - Ga naar deze directory, aangezien het project hier terug te vinden is
8. ```composer install``` - Installeer alle dependencies en modules
9. ```php artisan key:generate``` - Genereer je persoonlijke APP key. Het is belangrijk dat je deze kopieert, aangezien je deze nog gaat nodig hebben in de volgende stappen.
10. ```php artisan migrate --seed``` - Zorg voor dummy content in de databases
11. ```logout``` - Ga terug naar je lokale terminal

**Lokaal**

12. Open het project in een IDE naar keuze (PHPStorm, Brackets, Sublime, ...)
13. Open ```config/app.php```. Scroll naar ```'key' => env('APP_KEY', '<Your own app key>'),```, en plak hier je eigen APP key in.
14. Maak in de parent directory een ```.env``` file aan, en kopieer de inhoud van ```.env.example``` hierin.
15. Pas hierin opnieuw ```APP_KEY``` aan naar je eigen gegenereerde key.

Waar we nog voor moeten zorgen, is dat we naar een url kunnen surfen om de website te kunnen bekijken i.p.v. een IP-adres.
Momenteel is de site al te bezichtigen op ```192.168.33.10```.

16. Open ```C:\Windows\System32\drivers\etc```.
17. Open het bestand ````hosts``` met een teksteditor naar keuze.
18. Zet onderaan het bestand het volgende: ```192.168.33.10		www.laddder.local laddder.local www.laddder.dev laddder.dev```.

Je laddder setup is klaar voor gebruik!