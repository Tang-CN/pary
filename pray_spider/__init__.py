import requests
from lxml import etree
import json
import time
import os


class Pray:
    baseUrl = 'https://www.yysj.com'
    url = 'https://www.yysj.com/guanyin/{}.html'
    headers = {

        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36"
    }
    fwqUrl = 'http://127.0.0.1:8000/static/images/'

    def __init__(self):
        self.url_list = []
        self.pray_list = []
        self.img_save_dir = 'images'  # Change the directory to 'images'
        if not os.path.exists(self.img_save_dir):
            os.makedirs(self.img_save_dir)
        for i in range(2):
            url = self.url.format(i + 1)
            self.url_list.append(url)

    def download_image(self, img_url, save_path):
        img_res = requests.get(img_url, headers=self.headers)
        if img_res.status_code == 200:
            with open(save_path, 'wb') as f:
                f.write(img_res.content)
            return save_path
        else:
            print(f"download image error: {img_url}")
            return None

    def get_page_data(self, url, baseUrl, fwqUrl):
        res = requests.get(url, headers=self.headers)
        html = etree.HTML(res.content.decode('utf-8'))
        data_list = html.xpath('//div[@class="lq-detail-body"]')
        for item in data_list:
            img = item.xpath('.//img/@src')[0]
            tit = item.xpath('.//div[@class="tit"]/text()')
            red = item.xpath('.//span[@class="red"][1]/text()')
            td = item.xpath('.//tr/td/text()')
            div = item.xpath('.//tr/td/div/text()')
            img_filename = os.path.join(self.img_save_dir, img.split('/')[-1])
            full_url = baseUrl + img
            self.download_image(full_url, img_filename)
            if img:
                pray_data = {'title': tit[0], 'href': fwqUrl + img.split('/')[-1], 'name': red[0], 'zq': red[1],
                             'sy': td[0],
                             'jy': td[1],
                             'qy': td[2],
                             'xj': td[3], 'dg': ''.join(div)}
                self.pray_list.append(pray_data)
                print(pray_data)

    def save_to_json(self, filename='pray.json'):
        with open(filename, 'w', encoding='utf-8') as f:
            json.dump(self.pray_list, f, ensure_ascii=False, indent=4)

    def run(self):
        for url in self.url_list:
            print('==========当前url', url)
            self.get_page_data(url, self.baseUrl, self.fwqUrl)
            # 爬慢一点 防止封
            time.sleep(10)
        self.save_to_json()


if __name__ == '__main__':
    guanyin = Pray()
    guanyin.run()
