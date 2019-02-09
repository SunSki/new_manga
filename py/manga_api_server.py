# 必要なモジュールの読み込み
from flask import Flask, jsonify, abort, make_response

# スクレイピング用ライブラリ
import requests
from bs4 import BeautifulSoup

import json
import collections as cl

# 正規表現
import re

from time import sleep

from datetime import datetime

# Flaskクラスのインスタンスを作成
# __name__は現在のファイルのモジュール名
api = Flask(__name__)
api.config['JSON_AS_ASCII'] = False

global tonari_res
global plus_res
global young_res

site_url = {'plus': 'https://shonenjumpplus.com/series',
            'tonari': 'https://tonarinoyj.jp/series',
            'young': 'https://web-ace.jp/youngaceup/contents/'}


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
        # for a in title_a_list[:5]:
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
        sleep(0.1)

    print('finished')

    sleep(1)
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
        # for link in links[:5]:
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
        sleep(0.1)

    print('finish')
    sleep(1)

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
        # for a in link_list[:5]:
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
            sleep(0.1)
    print('finish')
    sleep(1)
    return sort_date(json)
# GETの実装


@api.route('/get_jampplus', methods=['GET'])
def get_jampplus():
    return make_response(jsonify(plus_res))


@api.route('/get_tonari', methods=['GET'])
def get_tonari():
    return make_response(jsonify(tonari_res))


@api.route('/get_young', methods=['GET'])
def get_young():
    return make_response(jsonify(young_res))


@api.route('/get_all', methods=['GET'])
def get_all():
    res = plus_res + tonari_res + young_res
    res = sorted(res, key=lambda x: x['date'], reverse=True)
    return make_response(jsonify(res))

# エラーハンドリング


@api.errorhandler(404)
def not_found(error):
    return make_response(jsonify({'error': 'Not found'}), 404)


# ファイルをスクリプトとして実行した際に
# ホスト0.0.0.0, ポート3001番でサーバーを起動
if __name__ == '__main__':
    with api.app_context():  # global変数使うため　flask用
        plus_res = jampplusGet()
    with api.app_context():
        tonari_res = tonariGet()
    with api.app_context():
        young_res = youngGet()

    api.run(host='0.0.0.0', port=3001)
