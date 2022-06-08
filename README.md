# Bridge Tournament Participant Submission

## Podstawowe pojęcia
### Tournament
    Pojedyncze wydrzenie w którym może wziąć udział grupa Participantów o ile złożą oni poprawne Submission
### Submission
    Zgłoszenie o uczestnictwo w Tournament, Musi zawierac MembershipCardId przynajmniej jednego Participanta
### Participant
    Członek stowarzyszenia identyfikujący się unikalnym MembershipCardId
### Waiting List
    Lista Participantów których Submission nie zostało zakończone pozytywnie
### MembershipCardId
    Identifikator unikalny posiadany przez każdego Participanta

## Podstawowe reguły biznesowe 

 * Pojedynczy partycypant nie może występować w więcej niż jednym Submission
 * Submission jest uznana za zakończoną powodzeniem jeśli na zawiera dwóch Participant's
 * Participant z Submission w którym nie udało się zakończyc powodzeniem trafia na Waiting List
 * Submission może być zgłoszona z tylko jednym Participant - system wyszuka brakującego Participant w Waiting List
 * Participant dobrany do Submission z Waiting List jest z niej usuwany

## Dodatkowe reguły i założenia techniczne na potrzeby tego demo
 * Cała persystencja opiera się o Redis'a
 * Pełna implementacja CQRS - na potrzeby prezentacji danych wykorzystywne są projekcje budowane jako side-effekty zdarzeń domenowych
   * Wykorzystane jest kilka strategii budowania projekcji - przez eventy i przez dodatkowe akcje CommandHandler'ów
 * Architektura aplikacji nie bazuje na żadnej oficjalnej architekturze "DDD" (nie jest to Hexagonal),
   * Architektura jest zgodna "ideowo" z Hexagonal - wydziela warstwe Domenową a pozostałe traktuje jako byty zewnętrzene 
     o których domena nie ma wiedzy
 * Nie ma tu pełnego Event Sourcingu - zaimplementowane jest częsciowe Event Driven
 * Aplikacja poziada kilka błędów
 * Nie wszystkie projekcje zostały zaimplementowane w pełni
 * Projekt będzie rozwijany i uzupełniany, PR mile widziane
