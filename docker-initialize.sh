# delete Hello World
wp post delete 1 --force

wp post create \
  --post_type=post \
  --post_title='Test QuoteTweet' \
  --post_content='Lorem Ipsum' \
  --post_status='publish'