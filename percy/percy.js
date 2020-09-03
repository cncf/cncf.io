const PercyScript = require('@percy/script');
let rooturl = process.argv[2];
let delay = 10000;

PercyScript.run(async (page, percySnapshot) => {
  await page.goto(rooturl);
  await page.waitFor(delay);
  await percySnapshot('homepage');

  await page.goto(rooturl + 'projects/');
  await page.waitFor(delay);
  await percySnapshot('projects');

  await page.goto(rooturl + 'about/faq/');
  await page.waitFor(delay);
  await percySnapshot('faq');

  await page.goto(rooturl + 'community/webinars/');
  await page.waitFor(delay);
  await percySnapshot('webinars');

  await page.goto(rooturl + 'blog/');
  await page.waitFor(delay);
  await percySnapshot('blog');

  await page.goto(rooturl + 'news/');
  await page.waitFor(delay);
  await percySnapshot('news');

  await page.goto(rooturl + 'people/staff/');
  await page.waitFor(delay);
  await percySnapshot('staff');

  await page.goto(rooturl + 'about/contact/');
  await page.waitFor(delay);
  await percySnapshot('contact');

  await page.goto(rooturl + 'speakers/');
  await page.waitFor(delay);
  await percySnapshot('speakers bureau');

  await page.goto(rooturl + 'case-studies/');
  await page.waitFor(delay);
  await percySnapshot('case studies');

  await page.goto(rooturl + 'webinars/');
  await page.waitFor(delay);
  await percySnapshot('webinars');

});