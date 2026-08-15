import json

with open('c:/xampp/htdocs/Alumini_Compass_plateform/collection.json', 'r', encoding='utf-8') as f:
    d = json.load(f)

def extract(items):
    for item in items:
        if 'request' in item:
            req = item['request']
            url = req.get('url', '')
            if isinstance(url, dict):
                url = url.get('raw', '')
            if 'ai/infer' in url:
                print(json.dumps(req.get('body', {}), indent=2))
        if 'item' in item:
            extract(item['item'])

extract(d.get('item', []))
