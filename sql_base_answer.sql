1
SELECT uniform_num,name,club
FROM PLAYERS

2
SELECT *
FROM countries
WHERE group_name = "C"

3
SELECT *
FROM countries
WHERE group_name <> "C"

4
SELECT * FROM players WHERE TIMESTAMPDIFF(YEAR, `birth`, CURDATE()) >= 40

5
SELECT *
FROM players
WHERE height < 170

6
SELECT * FROM countries WHERE ranking BETWEEN 36 and 56

7
SELECT * FROM players WHERE position IN ("GK", "DF", "MF")

8
SELECT * FROM `goals` WHERE player_id IS NULL

9
SELECT * FROM `goals` WHERE player_id IS NOT NULL

10
SELECT * FROM players WHERE name LIKE "%ニョ"

11
SELECT * FROM players WHERE name LIKE "%ニョ%"

12
SELECT * FROM countries WHERE NOT group_name = "A"

13
SELECT * FROM players WHERE weight / POW(height / 100, 2) BETWEEN 20 and 29

14
SELECT * FROM players WHERE weight < 60 OR height < 165

15
SELECT * FROM players WHERE (position = "MF" OR position = "FW") AND height < 170

16
SELECT DISTINCT position FROM players

17
SELECT name, club, height + weight FROM players

18
SELECT CONCAT(name,"選手のポシションは'", position,"'です") FROM players

19
SELECT name, club, height + weight as "体力指数" FROM players

20
SELECT name FROM countries ORDER BY ranking ASC

21
SELECT * FROM players ORDER BY birth DESC

22
SELECT * FROM players ORDER BY height DESC, weight DESC

23
SELECT SUBSTRING(position, 1, 1) FROM players

24
SELECT name, LENGTH(name) FROM countries ORDER BY LENGTH(name) DESC

25
SELECT name, DATE_FORMAT(birth, '%Y年%m月%d日') AS birthday FROM players

26
SELECT IFNULL(player_id, 9999) as player_id, goal_time FROM `goals` WHERE 1

27
SELECT CASE WHEN player_id IS NULL THEN 9999 ELSE player_id END as player_id, goal_time FROM goals

28
SELECT avg(height) as "平均身長", avg(weight) as "平均体重" FROM players

29
SELECT count(*) as "日本のゴール数" FROM goals WHERE player_id between 714 and 736

30
SELECT count(player_id) FROM goals

31
SELECT MAX(height), MAX(weight) FROm players

32
SELECT MIN(ranking) FROM countries where group_name = "A"

33
SELECT SUM(ranking) FROM countries where group_name = "C"

34
SELECT players.name, countries.name, uniform_num FROM `players`, countries WHERE players.country_id = countries.id

35
SELECT countries.name, players.name, goal_time FROM countries, players, goals where players.id = goals.player_id and players.country_id = countries.id

36
SELECT goal_time, name
FROM goals LEFT JOIN players 
ON goals.player_id = players.id

37
SELECT goal_time, name
FROM players RIGHT JOIN goals
ON goals.player_id = players.id

38
SELECT goal_time, p.name, c.name FROM players p RIGHT JOIN goals ON goals.player_id = p.id LEFT JOIN countries c ON c.id = p.country_id

39
SELECT kickoff, countries.name as enemy_country from pairings, countries where pairings.enemy_country_id = countries.id

40
SELECT goal_time FROM goals WHERE goals.player_id in (SELECT players.id from players)

41
SELECT goal_time, players.name FROM goals, players WHERE goals.player_id = players.id

42
SELECT p.position, 最大身長, NAME, club FROM ( SELECT POSITION, MAX(height) AS "最大身長" FROM players GROUP BY POSITION ) p left join players on 最大身長 = height and p.position = players.position

43
SELECT position, MAX(height) as 最大身長, (SELECT name FROm players p2 where p2.height = MAX(p1.height) and p2.position = p1.position) FROM players p1 GROUP BY position

44
SELECT uniform_num, position, name, height FROM players WHERE height < (SELECT avg(height) from players)

45
SELECT group_name, max(ranking), min(ranking) FROM countries GROUP BY group_name having max(ranking)-min(ranking) > 50

46
SELECT dear.誕生年, dear.カウント数 FROM (SELECT SUBSTRING(birth ,1 ,4) as 誕生年, count(id) as カウント数 FROM players GROUP BY SUBSTRING(birth ,1 ,4)) dear WHERE dear.誕生年 = "1980" UNION SELECT dear.誕生年, dear.カウント数 FROM (SELECT SUBSTRING(birth ,1 ,4) as 誕生年, count(id) as カウント数 FROM players GROUP BY SUBSTRING(birth ,1 ,4)) dear WHERE dear.誕生年 = "1981"

47
SELECT id, position, name, height, weight FROM players WHERE height > 195 or weight > 95 UNION ALL SELECT id, position, name, height, weight FROM players WHERE height > 195 and weight > 95 ORDER BY name
