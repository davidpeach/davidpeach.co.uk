---
title: >-
  Average Semi-detached house prices in UK by county &#8211; Statistical
  Analysis using R
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-09-15T13:01:21.000Z
metadata:
  categories:
    - Programming
  tags:
    - ggplot
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=50771
  type: wordpress
  url: >-
    https://davidpeach.me/2023/09/15/average-semi-detached-house-prices-in-uk-by-county-statistical-analysis-using-r/
tags:
  - programming
---
This is my first data visualization attempt and uses data from HM Land Registry to show to average cost of a semi-detached house in four counties across the past ten years.

You can see the full repository for [the project on Github](https://github.com/davidpeach/average-semi-detached-prices-by-county).

## The Code

Here I have included the code at the time of writing this post. The git repository code may now differ slightly.

```
library("tidyverse")

regions  <- c(
  "Derbyshire",
  "Leicestershire",
  "Staffordshire",
  "Warwickshire"
)

data  <- read.csv("props.csv")

data %>%
  filter(Region_Name %in% regions) %>%
  filter(Date > "2013-01-01") %>%
  ggplot(aes(
    Date,
    Semi_Detached_Average_Price
  )) +
  geom_point(aes(color = Region_Name), size = 3) +
  theme_bw() +
  theme(axis.text.x = element_text(angle = 90, vjust = 0.5, hjust = 1)) +
  labs(
    title = "Average Semi-detached house prices per county",
    x = "Month and Year",
    y = "Average Price",
    color = "County"
  )

ggsave(
  "semi-detached-house-prices-derby-leicester-staffs-warwickshire.png",
  width = 4096,
  height = 2160,
  unit = "px"
)
```

## The Graph

[![Graph to show increasing semi-detached house prices by county.](/assets/semi-detached-house-prices-der-xUEILf7D0bvB.png)](/assets/semi-detached-house-prices-der-xUEILf7D0bvB.png)

## Observations

Warwickshire has been the most expensive county to buy a semi-detached house out of the four counties observed.

Derbyshire has been the least expensive county to buy a semi-detached house out of the four counties observed.

The shapes of the line formed seem consistent across the counties; the rate of price increase seems similar between them.

A lot can happen over ten years.