--
-- PostgreSQL database dump
--

-- Dumped from database version 14.5
-- Dumped by pg_dump version 14.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;


--
-- Data for Name: drink; Type: TABLE DATA; Schema: public; Owner: clochette
--

COPY public.drink (id, name) FROM stdin;
1	Cidre
2	IPA
3	Kronenbourg
4	BBT
\.


--
-- Data for Name: stock; Type: TABLE DATA; Schema: public; Owner: clochette
--

COPY public.stock (id) FROM stdin;
\.


--
-- Data for Name: treasury; Type: TABLE DATA; Schema: public; Owner: clochette
--

COPY public.treasury (id, total_amount, cash_amount) FROM stdin;
1	-1702	39.5
\.


--
-- Data for Name: transaction; Type: TABLE DATA; Schema: public; Owner: clochette
--

COPY public.transaction (id, datetime, payment_method, amount, sale, treasury_id) FROM stdin;
1	2022-11-30 19:52:25.498	card	150	f	1
2	2022-11-30 19:52:40.508	card	500	f	1
3	2022-11-30 20:07:49.412	card	220	f	1
4	2022-11-30 21:17:13.283	card	535	f	1
5	2022-11-30 21:34:32.866	lydia	7	t	1
6	2022-11-30 21:44:03.168	lydia	25	f	1
7	2022-11-30 23:35:20.949	cash	24	t	1
8	2022-11-30 23:35:22.419	cash	1	f	1
9	2022-12-01 01:20:00.377	cash	1	f	1
10	2022-12-01 01:27:49.86	cash	1	f	1
11	2022-12-01 11:49:56.479	cash	1.5	t	1
12	2022-12-01 11:53:45.284	cash	10	t	1
13	2022-12-01 14:45:36.064	lydia	4	t	1
14	2022-12-01 18:32:10.48	lydia	8	t	1
15	2022-12-01 20:16:53.04	cash	1	t	1
16	2022-12-01 20:18:36.549	cash	5	t	1
17	2022-12-01 20:38:46.857	cash	0.5	t	1
18	2022-12-01 20:38:50.003	cash	0.5	t	1
19	2022-12-01 23:38:16.179	lydia	4	t	1
20	2022-12-01 23:50:26.585	lydia	6	t	1
21	2022-12-01 23:50:45.147	lydia	5	t	1
22	2022-12-02 13:20:57.895	lydia	4.5	t	1
\.


--
-- Data for Name: barrel; Type: TABLE DATA; Schema: public; Owner: clochette
--

COPY public.barrel (id, unit_price, sell_price, is_mounted, empty, drink_id, stock_id, transaction_id) FROM stdin;
3	50	2	f	f	1	\N	1
4	100	3	f	f	2	\N	2
5	100	3	f	f	2	\N	2
1	50	2	t	f	1	\N	1
2	50	2	f	f	1	\N	1
6	100	3	f	f	2	\N	2
8	100	3	f	f	2	\N	2
7	100	3	t	f	2	\N	2
9	110	4	f	f	3	\N	3
10	110	4	t	f	3	\N	3
11	9.807692307692308	4	f	f	3	\N	4
12	9.807692307692308	4	f	f	3	\N	4
13	9.807692307692308	4	f	f	3	\N	4
14	9.807692307692308	4	f	f	3	\N	4
15	9.807692307692308	4	f	f	3	\N	4
20	9.807692307692308	4	f	f	3	\N	4
21	9.807692307692308	4	f	f	3	\N	4
22	9.807692307692308	4	f	f	3	\N	4
23	9.807692307692308	4	f	f	3	\N	4
24	9.807692307692308	4	f	f	3	\N	4
25	9.807692307692308	4	f	f	3	\N	4
26	9.807692307692308	4	f	f	3	\N	4
27	9.807692307692308	4	f	f	3	\N	4
28	9.807692307692308	4	f	f	3	\N	4
29	9.807692307692308	4	f	f	3	\N	4
30	9.807692307692308	4	f	f	3	\N	4
31	9.807692307692308	4	f	f	3	\N	4
32	9.807692307692308	4	f	f	3	\N	4
33	9.807692307692308	4	f	f	3	\N	4
34	9.807692307692308	4	f	f	3	\N	4
35	9.807692307692308	4	f	f	3	\N	4
36	9.807692307692308	4	f	f	3	\N	4
37	9.807692307692308	4	f	f	3	\N	4
38	9.807692307692308	4	f	f	3	\N	4
39	9.807692307692308	4	f	f	3	\N	4
40	9.807692307692308	4	f	f	3	\N	4
41	9.807692307692308	4	f	f	3	\N	4
42	9.807692307692308	4	f	f	3	\N	4
43	9.807692307692308	4	f	f	3	\N	4
44	9.807692307692308	4	f	f	3	\N	4
45	9.807692307692308	4	f	f	3	\N	4
46	9.807692307692308	4	f	f	3	\N	4
47	9.807692307692308	4	f	f	3	\N	4
48	9.807692307692308	4	f	f	3	\N	4
49	9.807692307692308	4	f	f	3	\N	4
50	9.807692307692308	4	f	f	3	\N	4
51	9.807692307692308	4	f	f	3	\N	4
52	9.807692307692308	4	f	f	3	\N	4
53	9.807692307692308	4	f	f	3	\N	4
54	9.807692307692308	4	f	f	3	\N	4
55	9.807692307692308	4	f	f	3	\N	4
56	9.807692307692308	4	f	f	3	\N	4
57	9.807692307692308	4	f	f	3	\N	4
58	9.807692307692308	4	f	f	3	\N	4
59	9.807692307692308	4	f	f	3	\N	4
60	9.807692307692308	4	f	f	3	\N	4
61	9.807692307692308	4	f	f	3	\N	4
62	9.807692307692308	4	f	f	3	\N	4
16	9.807692307692308	4	f	f	3	\N	4
17	9.807692307692308	4	f	f	3	\N	4
18	9.807692307692308	4	f	f	3	\N	4
19	9.807692307692308	4	f	f	3	\N	4
\.


--
-- Data for Name: consumableitem; Type: TABLE DATA; Schema: public; Owner: clochette
--

COPY public.consumableitem (id, name, icon) FROM stdin;
1	Coca	soft
\.


--
-- Data for Name: consumable; Type: TABLE DATA; Schema: public; Owner: clochette
--

COPY public.consumable (id, sell_price, unit_price, empty, consumable_item_id, stock_id, transaction_id_purchase, transaction_id_sale) FROM stdin;
9	0.5	0.45454545454545453	f	1	\N	4	\N
10	0.5	0.45454545454545453	f	1	\N	4	\N
11	0.5	0.45454545454545453	f	1	\N	4	\N
12	0.5	0.45454545454545453	f	1	\N	4	\N
13	0.5	0.45454545454545453	f	1	\N	4	\N
14	0.5	0.45454545454545453	f	1	\N	4	\N
15	0.5	0.45454545454545453	f	1	\N	4	\N
16	0.5	0.45454545454545453	f	1	\N	4	\N
17	0.5	0.45454545454545453	f	1	\N	4	\N
18	0.5	0.45454545454545453	f	1	\N	4	\N
19	0.5	0.45454545454545453	f	1	\N	4	\N
20	0.5	0.45454545454545453	f	1	\N	4	\N
21	0.5	0.45454545454545453	f	1	\N	4	\N
22	0.5	0.45454545454545453	f	1	\N	4	\N
23	0.5	0.45454545454545453	f	1	\N	4	\N
24	0.5	0.45454545454545453	f	1	\N	4	\N
25	0.5	0.45454545454545453	f	1	\N	4	\N
26	0.5	0.45454545454545453	f	1	\N	4	\N
27	0.5	0.45454545454545453	f	1	\N	4	\N
28	0.5	0.45454545454545453	f	1	\N	4	\N
29	0.5	0.45454545454545453	f	1	\N	4	\N
30	0.5	0.45454545454545453	f	1	\N	4	\N
31	0.5	0.45454545454545453	f	1	\N	4	\N
32	0.5	0.45454545454545453	f	1	\N	4	\N
33	0.5	0.45454545454545453	f	1	\N	4	\N
34	0.5	0.45454545454545453	f	1	\N	4	\N
35	0.5	0.45454545454545453	f	1	\N	4	\N
36	0.5	0.45454545454545453	f	1	\N	4	\N
37	0.5	0.45454545454545453	f	1	\N	4	\N
38	0.5	0.45454545454545453	f	1	\N	4	\N
39	0.5	0.45454545454545453	f	1	\N	4	\N
40	0.5	0.45454545454545453	f	1	\N	4	\N
41	0.5	0.45454545454545453	f	1	\N	4	\N
42	0.5	0.45454545454545453	f	1	\N	4	\N
43	0.5	0.45454545454545453	f	1	\N	4	\N
44	0.5	0.45454545454545453	f	1	\N	4	\N
45	0.5	0.45454545454545453	f	1	\N	4	\N
46	0.5	0.45454545454545453	f	1	\N	4	\N
47	0.5	0.45454545454545453	f	1	\N	4	\N
48	0.5	0.45454545454545453	f	1	\N	4	\N
49	0.5	0.45454545454545453	f	1	\N	4	\N
50	0.5	0.45454545454545453	f	1	\N	4	\N
51	0.5	0.45454545454545453	f	1	\N	4	\N
52	0.5	0.45454545454545453	f	1	\N	4	\N
53	0.5	0.45454545454545453	f	1	\N	4	\N
54	0.5	0.45454545454545453	f	1	\N	4	\N
55	0.5	0.45454545454545453	f	1	\N	4	\N
56	0.5	0.45454545454545453	f	1	\N	6	\N
57	0.5	0.45454545454545453	f	1	\N	6	\N
58	0.5	0.45454545454545453	f	1	\N	6	\N
59	0.5	0.45454545454545453	f	1	\N	6	\N
60	0.5	0.45454545454545453	f	1	\N	6	\N
61	0.5	0.45454545454545453	f	1	\N	6	\N
62	0.5	0.45454545454545453	f	1	\N	6	\N
63	0.5	0.45454545454545453	f	1	\N	6	\N
64	0.5	0.45454545454545453	f	1	\N	6	\N
65	0.5	0.45454545454545453	f	1	\N	6	\N
66	0.5	0.45454545454545453	f	1	\N	6	\N
67	0.5	0.45454545454545453	f	1	\N	6	\N
68	0.5	0.45454545454545453	f	1	\N	6	\N
69	0.5	0.45454545454545453	f	1	\N	6	\N
70	0.5	0.45454545454545453	f	1	\N	6	\N
71	0.5	0.45454545454545453	f	1	\N	6	\N
72	0.5	0.45454545454545453	f	1	\N	6	\N
73	0.5	0.45454545454545453	f	1	\N	6	\N
74	0.5	0.45454545454545453	f	1	\N	6	\N
75	0.5	0.45454545454545453	f	1	\N	6	\N
76	0.5	0.45454545454545453	f	1	\N	6	\N
77	0.5	0.45454545454545453	f	1	\N	6	\N
78	0.5	0.45454545454545453	f	1	\N	6	\N
79	0.5	0.45454545454545453	f	1	\N	6	\N
80	0.5	0.45454545454545453	f	1	\N	6	\N
81	0.5	0.45454545454545453	f	1	\N	6	\N
82	0.5	0.45454545454545453	f	1	\N	6	\N
83	0.5	0.45454545454545453	f	1	\N	6	\N
84	0.5	0.45454545454545453	f	1	\N	6	\N
85	0.5	0.45454545454545453	f	1	\N	6	\N
86	0.5	0.45454545454545453	f	1	\N	6	\N
87	0.5	0.45454545454545453	f	1	\N	6	\N
88	0.5	0.45454545454545453	f	1	\N	6	\N
89	0.5	0.45454545454545453	f	1	\N	6	\N
90	0.5	0.45454545454545453	f	1	\N	6	\N
91	0.5	0.45454545454545453	f	1	\N	6	\N
92	0.5	0.45454545454545453	f	1	\N	6	\N
93	0.5	0.45454545454545453	f	1	\N	6	\N
94	0.5	0.45454545454545453	f	1	\N	6	\N
95	0.5	0.45454545454545453	f	1	\N	6	\N
96	0.5	0.45454545454545453	f	1	\N	6	\N
97	0.5	0.45454545454545453	f	1	\N	6	\N
98	0.5	0.45454545454545453	f	1	\N	6	\N
99	0.5	0.45454545454545453	f	1	\N	6	\N
100	0.5	0.45454545454545453	f	1	\N	6	\N
101	0.5	0.45454545454545453	f	1	\N	6	\N
102	0.5	0.45454545454545453	f	1	\N	6	\N
103	0.5	0.45454545454545453	f	1	\N	6	\N
104	0.5	0.45454545454545453	f	1	\N	6	\N
105	0.5	0.45454545454545453	f	1	\N	6	\N
106	0.5	0.45454545454545453	f	1	\N	6	\N
107	0.5	0.45454545454545453	f	1	\N	6	\N
108	0.5	0.45454545454545453	f	1	\N	6	\N
109	0.5	0.45454545454545453	f	1	\N	6	\N
110	0.5	0.45454545454545453	f	1	\N	6	\N
1	0.5	0.45454545454545453	t	1	\N	4	11
2	0.5	0.45454545454545453	t	1	\N	4	11
3	0.5	0.45454545454545453	t	1	\N	4	11
4	0.5	0.45454545454545453	t	1	\N	4	15
5	0.5	0.45454545454545453	t	1	\N	4	15
6	0.5	0.45454545454545453	t	1	\N	4	17
7	0.5	0.45454545454545453	t	1	\N	4	18
8	0.5	0.45454545454545453	t	1	\N	4	22
\.


--
-- Data for Name: glass; Type: TABLE DATA; Schema: public; Owner: clochette
--

COPY public.glass (id, barrel_id, transaction_id) FROM stdin;
1	7	5
2	1	5
3	10	12
4	10	12
5	1	13
6	1	13
7	7	14
8	10	16
9	10	20
10	1	20
11	10	21
12	7	22
\.


--
-- Data for Name: outofstockitem; Type: TABLE DATA; Schema: public; Owner: clochette
--

COPY public.outofstockitem (id, buy_or_sell, name, icon, sell_price) FROM stdin;
1	t	EcoCup	glass	\N
2	f	EcoCup	glass	1
3	f	Planchette charcuterie	food	4
\.


--
-- Data for Name: outofstock; Type: TABLE DATA; Schema: public; Owner: clochette
--

COPY public.outofstock (id, unit_price, item_id, transaction_id) FROM stdin;
1	\N	2	5
2	\N	2	5
3	\N	3	7
4	\N	3	7
5	\N	3	7
6	\N	3	7
7	\N	3	7
8	\N	3	7
9	1	1	8
10	1	1	9
11	1	1	10
12	\N	2	12
13	\N	2	12
14	\N	3	14
15	\N	2	14
16	\N	2	16
17	\N	3	19
18	\N	2	21
19	\N	2	22
\.


--
-- Name: barrel_id_seq; Type: SEQUENCE SET; Schema: public; Owner: clochette
--

SELECT pg_catalog.setval('public.barrel_id_seq', 62, true);


--
-- Name: consumable_id_seq; Type: SEQUENCE SET; Schema: public; Owner: clochette
--

SELECT pg_catalog.setval('public.consumable_id_seq', 110, true);


--
-- Name: consumableitem_id_seq; Type: SEQUENCE SET; Schema: public; Owner: clochette
--

SELECT pg_catalog.setval('public.consumableitem_id_seq', 1, true);


--
-- Name: drink_id_seq; Type: SEQUENCE SET; Schema: public; Owner: clochette
--

SELECT pg_catalog.setval('public.drink_id_seq', 4, true);


--
-- Name: glass_id_seq; Type: SEQUENCE SET; Schema: public; Owner: clochette
--

SELECT pg_catalog.setval('public.glass_id_seq', 12, true);


--
-- Name: outofstock_id_seq; Type: SEQUENCE SET; Schema: public; Owner: clochette
--

SELECT pg_catalog.setval('public.outofstock_id_seq', 19, true);


--
-- Name: outofstockitem_id_seq; Type: SEQUENCE SET; Schema: public; Owner: clochette
--

SELECT pg_catalog.setval('public.outofstockitem_id_seq', 3, true);


--
-- Name: stock_id_seq; Type: SEQUENCE SET; Schema: public; Owner: clochette
--

SELECT pg_catalog.setval('public.stock_id_seq', 1, false);


--
-- Name: transaction_id_seq; Type: SEQUENCE SET; Schema: public; Owner: clochette
--

SELECT pg_catalog.setval('public.transaction_id_seq', 22, true);


--
-- Name: treasury_id_seq; Type: SEQUENCE SET; Schema: public; Owner: clochette
--

SELECT pg_catalog.setval('public.treasury_id_seq', 1, true);


--
-- PostgreSQL database dump complete
--

