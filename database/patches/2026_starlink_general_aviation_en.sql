INSERT INTO news_items (
    lang,
    title,
    slug,
    category,
    image_path,
    comment_count,
    teaser,
    body,
    published_at,
    is_published
)
VALUES (
    'en',
    'Starlink Back On Board: Practical Experience from a PA-46',
    'starlink-general-aviation-pa46',
    'Technology',
    '/assets/img/news/starlink-pa46-2026.jpg',
    0,
    'An MMIG46 member shares practical experience: with the correct General Aviation plan, Starlink works in flight again. Support activation and careful management of data usage are crucial.',
    'A stable internet connection on board is now a realistic option in general aviation. However, a recent experience report from the MMIG46 community shows that the hardware alone is not enough. The decisive factor is a service plan that is explicitly enabled for use in flight.

During a flight over Marseille towards LJPZ, Starlink was available in the air again after the correct plan had been activated.

## The correct plan is essential

Initially, a different Global plan had been reactivated. The connection worked without problems on the ground, but later stopped working in flight. Contacting Starlink Support provided the crucial clarification: in this case, the **General Aviation Local 50 GB** plan was required for airborne use.

This Aviation plan was not offered directly in the customer account and had to be requested from Support. For activation, Starlink requested aircraft details and proof of identity. Such documents should be submitted only through the official support area while signed in to the account. Once the required information had been provided, the plan was activated within a few hours.

## Cost and data allowance

For the account concerned, Starlink confirmed a monthly price of **EUR 135 for 50 GB**, plus any applicable taxes. According to the experience report, a further 50 GB can be added for EUR 50.

The included 50 GB is not an unlimited allowance. However, with Low Data Mode enabled on connected devices and careful management of automatic updates, cloud synchronisation and video streaming, it should often be sufficient for typical use on board. Actual consumption depends heavily on the applications used and the number of connected devices.

## Recommended procedure

1. Before using the service, confirm that the selected plan is explicitly approved for Aviation and airborne use.
2. If the appropriate plan is not shown in the customer account, contact Starlink Support through the signed-in support area.
3. Have the aircraft registration and any requested documents ready, and submit them only through the official channel.
4. After the change, verify the exact plan name in the customer account.
5. Enable Low Data Mode on smartphones, tablets and laptops, and restrict data-intensive background processes.
6. Test the connection under controlled conditions before relying on it during a longer trip.

## Conclusion

The experience report is encouraging: Starlink can provide a capable internet connection in a PA-46 for communication and general online services. However, an ordinary Global or roaming plan is not automatically sufficient. The correct Aviation plan and its proper activation are essential.

Starlink supplements communication on board but does not replace approved avionics or primary operational systems. Plans, availability, permitted use and pricing may also change and should be checked against the latest Starlink information before subscribing.

Experience report dated 18 August 2026.

[Current Starlink information on General Aviation plans](https://starlink.com/support/article/9839230e-dc08-21e6-a94d-e7c04cacdd1b)',
    '2026-09-07 12:00:00',
    1
)
ON DUPLICATE KEY UPDATE
    title = VALUES(title),
    category = VALUES(category),
    image_path = VALUES(image_path),
    comment_count = VALUES(comment_count),
    teaser = VALUES(teaser),
    body = VALUES(body),
    published_at = VALUES(published_at),
    is_published = VALUES(is_published);
