# -*- coding: utf-8 -*-

# スクレイピング用ライブラリ
import requests
from bs4 import BeautifulSoup

import json
import collections as cl

import re  # 正規表現
import schedule
import time
from datetime import datetime

import sqlite3

site_url = {'plus': 'https://shonenjumpplus.com/series',
            'tonari': 'https://tonarinoyj.jp/series',
            'young': 'https://web-ace.jp/youngaceup/contents/',
            'ura': 'https://urasunday.com/list/index.html'}

sleepTime = 0.1


def to_json(title, link, date, site, img, detail):
    json = {}
    json["title"] = title
    json["link"] = link
    json["date"] = date
    json["site"] = site
    json["img"] = img
    json["detail"] = detail
    return json


def sort_date(json):
    return sorted(json, key=lambda x: x['date'], reverse=True)


def date_judge(date):
    now = datetime.now()
    time_list = date.split('/')
    time = datetime(int(time_list[0]), int(time_list[1]), int(time_list[2]))
    dif = (now - time).days
    return dif < 30

# plus


def jampplusGet():
    url = site_url['plus']
    response = requests.get(url)
    soup = BeautifulSoup(response.text, 'html.parser')

    title_a_list = []
    for link in soup.select('.series-list-item > a'):
        title_a_list.append(link.get('href'))
    json = []
    titles = []

    for a in title_a_list:  # 数の調整
        # for a in title_a_list[:4]:
        url = a
        response = requests.get(url)
        soup = BeautifulSoup(response.text, 'html.parser')

        link = soup.find('a', class_='series-episode-list-container')
        title = soup.find(class_='series-header-title')
        date = soup.find(class_='series-episode-list-date')
        private = soup.find(class_='series-episode-list-container')
        detail = soup.select_one("h4.series-episode-list-title")
        img = soup.select_one(
            "div.series-header-image-wrapper > img")

        if link != None and title != None and img != None:
            if title.text not in titles:
                if re.search('公開は終了しました', private.text) == None:
                    date = date.text
                    if date_judge(date):
                        img = img.get('src')
                        detail = detail.text
                        json.append(
                            to_json(title.text, link.get('href'), date, 'plus', img, detail))
                        titles.append(title.text)
                        print(title.text)
                        print(date)
                        print(img)
                    else:
                        print('更新されてない')
                else:
                    print('公開終了:' + title.text)
            else:
                print('重複:' + title.text)
        else:
            print('ダメ')
        time.sleep(sleepTime)

    print('finished')
    return sort_date(json)

# tonari


def tonariGet():
    url = site_url['tonari']
    response = requests.get(url)
    soup = BeautifulSoup(response.text, 'html.parser')

    json = []
    title_list = []
    title_link = soup.select('h4.daily-series-title')
    links = soup.select('ul.daily-series-episode-link-list')
    pattern = 'https://tonarinoyj.jp/episode/\d+'
    i = 0
    for link in links:
        # for link in links[:4]:
        results = re.findall(pattern, str(link))
        if len(results) > 1:
            response = requests.get(results[1])
            soup = BeautifulSoup(response.text, 'html.parser')
            date = soup.find(class_='series-episode-list-date').text
            detail = soup.select_one("h4.series-episode-list-title").text
            if date_judge(date):
                title = title_link[i].text
                img = soup.select_one(
                    "div.series-header-image-wrapper > img").get('src')
                if title not in title_list:
                    print(title)
                    print(date)
                    print(img)
                    title_list.append(title)
                    json.append(
                        to_json(title, results[1], date, 'tonari', img, detail))
        i += 1
        time.sleep(sleepTime)

    print('finish')
    return sort_date(json)

# young


def youngGet():
    path = 'https://web-ace.jp'
    url = site_url['young']
    response = requests.get(url)
    soup = BeautifulSoup(response.text, 'html.parser')

    def date_change(date):
        d = date.replace('年', '/').replace('月', '/').replace('日', '')
        splits = d.split('/')
        if (len(splits[1]) < 2):
            splits[1] = '0' + splits[1]
        if (len(splits[2]) < 2):
            splits[2] = '0' + splits[2]
        result = splits[0] + '/' + splits[1] + '/' + splits[2]
        return result

    json = []
    link_list = []
    for link in soup.select('ul.current > li > a'):
        link_list.append(path+link.get('href'))

    for a in link_list:
        # for a in link_list[:4]:
        response = requests.get(a)
        soup = BeautifulSoup(response.text, 'html.parser')
        title = soup.select_one('div.credit > h1').text
        link = path + \
            soup.select_one('div.inner-news > ul > li > a').get('href')
        date = soup.select_one('span.updated-date').text
        date = date_change(date)
        if date_judge(date):
            img = path + soup.select_one(
                "div.inner-sakuhin-info > img").get('src')
            detail = soup.select_one('p.text-bold').text
            print(title)
            print(date)
            print(img)
            json.append(to_json(title, link, date, 'young', img, detail))
            time.sleep(sleepTime)
    print('finish')
    return sort_date(json)
# GETの実装


def uraGet():
    url = site_url['ura']
    site_path = 'https://urasunday.com'
    response = requests.get(url)
    soup = BeautifulSoup(response.text, 'html.parser')  # クローリング

    a_link_list = []
    for link in soup.select('div.comicListBox > a'):
        link = link.get('href')[2:]
        link = site_path + link
        a_link_list.append(link)

    json = []

    # for a in a_link_list[:4]:
    for a in a_link_list:
        url = a
        path = url[0:-10]
        response = requests.get(url)
        soup = BeautifulSoup(response.text, 'html.parser')

        date_s = soup.select_one("div.comicButtonDateBox")
        date = date_s.text[0:10]
        if date.startswith('20'):
            if date_judge(date):
                img_s = soup.select_one("section#mainControl > div > a > img")
                if img_s != None:
                    img = img_s.get('src')
                    title_s = soup.select_one("li.detailComicTitle > h1")
                    title = title_s.text
                    link_s = soup.select_one("div.comicButtonDateBox > a")
                    detail = link_s.text  #
                    link = path + link_s.get('href')[2:]  #
                    json.append(to_json(title, link, date, 'ura', img, detail))

                    print(title)
                    # print(detail)
                    # print(date)
                    # print(link)
                    # print(img)
        time.sleep(sleepTime)

    print("finish")
    return sort_date(json)


def job():
    # スクレイピング
    plus_res = jampplusGet()
    tonari_res = tonariGet()
    young_res = youngGet()
    ura_res = uraGet()

    res = young_res + tonari_res + ura_res + plus_res
    all_res = sorted(res, key=lambda x: x['date'], reverse=True)
    all_res_sort = sorted(res, key=lambda x: x['title'])

    plus = json.dumps(plus_res, ensure_ascii=False)
    plus = plus.replace("'", "")

    tonari = json.dumps(tonari_res, ensure_ascii=False)
    tonari = tonari.replace("'", "")

    young = json.dumps(young_res, ensure_ascii=False)
    young = young.replace("'", "")

    ura = json.dumps(ura_res, ensure_ascii=False)
    ura = ura.replace("'", "")

    allRes = json.dumps(all_res, ensure_ascii=False)
    allRes = allRes.replace("'", "")

    allRes_sort = json.dumps(all_res_sort, ensure_ascii=False)
    allRes_sort = allRes_sort.replace("'", "")

    conn = sqlite3.connect('manga-list.db')
    c = conn.cursor()

    c.executescript("INSERT INTO plus ('json') VALUES ('%s')" % plus)
    c.executescript("INSERT INTO tonari ('json') VALUES ('%s')" % tonari)
    c.executescript("INSERT INTO young ('json') VALUES ('%s')" % young)
    c.executescript("INSERT INTO ura ('json') VALUES ('%s')" % ura)
    c.executescript("INSERT INTO allManga ('json') VALUES ('%s')" % allRes)
    c.executescript(
        "INSERT INTO allManga_sort ('json') VALUES ('%s')" % allRes_sort)

    conn.commit()
    conn.close()


schedule.every().day.at("01:41").do(job)
schedule.every().day.at("11:10").do(job)

while True:
    schedule.run_pending()
